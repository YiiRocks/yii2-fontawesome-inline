<?php
namespace thoulah\fontawesome;

use yii\helpers\ArrayHelper;

/**
 * @method class(string $class)
 * @method append(bool $append)
 * @method fill(string $fill)
 * @method fixedWidth(bool $fixedWidth)
 * @method groupSize(string $groupSize)
 * @method height(int $height)
 * @method title(string $title)
 */
class IconComponent extends \yii\base\Component {
	protected $icon = [];

	public $config;
	public $defaults;

	/*
	 *	Construct
	 */
	public function __construct($config = []) {
		$this->defaults = new Options();

		if ($config)
			foreach (reset($config) as $key => $value)
				$this->defaults->$key = $value;

		parent::__construct($config);
	}

	public function name(string $name, ?string $style = null): self {
		$this->icon['name'] = $name;
		$this->icon['style'] = $style ?? $this->defaults->style;
		return $this;
	}

	/*
	 *  Return the complete ActiveField inputTemplate
	 */
	public function activeFieldAddon(): string {
		$Html = __NAMESPACE__."\\{$this->defaults->bootstrap}\\Html";
		$groupSize = ArrayHelper::remove($this->icon, 'groupSize', $this->defaults->groupSize);
		$append = ArrayHelper::getValue($this->icon, 'append', $this->defaults->append);

		return $Html::activeFieldAddon($groupSize, $append);
	}

	/*
	 *  Return the partial ActiveField inputTemplate for manual use
	 */
	public function activeFieldIcon(): string {
		$Html = __NAMESPACE__."\\{$this->defaults->bootstrap}\\Html";
		if (!isset($this->icon['fixedWidth']))
			ArrayHelper::setValue($this->icon, 'fixedWidth', $this->defaults->activeFormFixedWidth);

		$append = ArrayHelper::remove($this->icon, 'append', $this->defaults->append);
		$icon = $Html::activeFieldIcon($append);
		return str_replace('{icon}', $this, $icon);
	}

	public function __call($name, $value) {
		$this->icon[$name] = $value[0];
		return $this;
	}

	/*
	 *  Magic function, returns the SVG string
	 */
	public function __toString(): string {
		$svg = new Svg($this->defaults);
		$string = $svg->getString($this->icon);
		$this->icon = [];
		return $string;
	}
}
