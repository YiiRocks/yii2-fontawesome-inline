<?php
/**
 *  @link https://fontawesome.mr42.me/
 *  @license https://github.com/Thoulah/yii2-fontawesome-inline/blob/master/LICENSE
 */

namespace thoulah\fontawesome;

use yii\helpers\ArrayHelper;

/**
 * {@inheritdoc}
 */
class Icon extends \yii\web\View {
	/**
	 * @var object the default settings
	 */
	public $defaults;

	/**
	 * {@inheritdoc}
	 */
	public function __construct() {
		parent::__construct();
		$this->defaults = new Options();
	}

	/**
	 *  Outputs the SVG string.
	 */
	public function show(string $name, array $options = []): string {
		ArrayHelper::setValue($options, 'name', $name);

		$svg = new Svg($this->defaults);
		return $svg->getSvg($options);
	}

	/**
	 *  Returns the ActiveField inputTemplate.
	 */
	public function activeFieldAddon(string $name, array $options = []): string {
		$Html = __NAMESPACE__ . "\\{$this->defaults->bootstrap}\\Html";
		$groupSize = ArrayHelper::remove($options, 'groupSize', $this->defaults->groupSize);

		$append = ArrayHelper::getValue($options, 'append', $this->defaults->append);
		$icon = $Html::activeFieldAddon($groupSize, $append);
		return str_replace('{icon}', $this->activeFieldIcon($name, $options), $icon);
	}

	/**
	 *  Returns the ActiveField Icon.
	 */
	public function activeFieldIcon(string $name, array $options = []): string {
		$Html = __NAMESPACE__ . "\\{$this->defaults->bootstrap}\\Html";

		$append = ArrayHelper::remove($options, 'append', $this->defaults->append);
		$icon = $Html::activeFieldIcon($append);
		return str_replace('{icon}', $this->show($name, $options), $icon);
	}
}
