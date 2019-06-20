<?php
/**
 *  @link https://thoulah.mr42.me/fontawesome
 *  @license https://github.com/Thoulah/yii2-fontawesome-inline/blob/master/LICENSE
 */

namespace thoulah\fontawesome;

/*
 * IconComponent provides an easy way to access Font Awesome icons throughout your project. This\
 * allows you to override default settings once instead of per usage.
 *
 * Add `IconComponent` as component to your Yii config file:
 * ```php
 * 'components' => [
 * 	'fontawesome' => [
 * 		'class' => thoulah\fontawesome\IconComponent::class,
 * //		'config' => [
 * //			'fontAwesomeFolder' => '@npm/fontawesome-pro/svgs',
 * //			'style' => 'regular',
 * //		],
 * 	]
 * ]
 * ```
 *
 * Now you can globally insert an icon:
 * ```php
 * echo Yii::$app->fontawesome->name('at');
 * echo Yii::$app->fontawesome->name('github', 'brands')->fill->('#003865');
 * echo Yii::$app->fontawesome->name('font-awesome', 'brands')->class('yourClass');
 * ```
 *
 * The component will not register the CSS for you, so you can add this to your layout.
 * ```php
 * \thoulah\fontawesome\FontAwesomeAsset::register($this);
 * ```
 */

use yii\helpers\ArrayHelper;

/**
 * @method append(bool $append)
 * @method class(string $class)
 * @method fill(string $fill)
 * @method fixedWidth(bool $fixedWidth)
 * @method groupSize(string $groupSize)
 * @method height(int $height)
 * @method title(string $title)
 */
class IconComponent {
	protected $icon = [];
	public $config;
	public $defaults;

	/**
	 * Construct.
	 * @param mixed $config
	 */
	public function __construct($config = []) {
		$this->defaults = new Options();

		if ($config) {
			foreach (reset($config) as $key => $value) {
				$this->defaults->$key = $value;
			}
		}
	}

	public function __call($name, $value): self {
		$this->icon[$name] = $value[0];
		return $this;
	}

	/**
	 *  Magic function, returns the SVG string.
	 */
	public function __toString(): string {
		$svg = new Svg($this->defaults);
		$string = $svg->getString($this->icon);
		$this->icon = [];
		return $string;
	}

	public function name(string $name, ?string $style = null): self {
		$this->icon['name'] = $name;
		$this->icon['style'] = $style ?? $this->defaults->style;
		return $this;
	}

	/**
	 *  Return the complete ActiveField inputTemplate.
	 */
	public function activeFieldAddon(): string {
		$Html = __NAMESPACE__ . "\\{$this->defaults->bootstrap}\\Html";
		$groupSize = ArrayHelper::remove($this->icon, 'groupSize', $this->defaults->groupSize);
		$append = ArrayHelper::getValue($this->icon, 'append', $this->defaults->append);

		return $Html::activeFieldAddon($groupSize, $append);
	}

	/**
	 *  Return the partial ActiveField inputTemplate for manual use.
	 */
	public function activeFieldIcon(): string {
		$Html = __NAMESPACE__ . "\\{$this->defaults->bootstrap}\\Html";
		if (!isset($this->icon['fixedWidth'])) {
			ArrayHelper::setValue($this->icon, 'fixedWidth', $this->defaults->activeFormFixedWidth);
		}

		$append = ArrayHelper::remove($this->icon, 'append', $this->defaults->append);
		$icon = $Html::activeFieldIcon($append);
		return str_replace('{icon}', $this, $icon);
	}
}
