<?php
/**
 * @link https://fontawesome.mr42.me/
 * @license https://github.com/Thoulah/yii2-fontawesome-inline/blob/master/LICENSE
 */

namespace thoulah\fontawesome;

use thoulah\fontawesome\config\Defaults;
use yii\helpers\ArrayHelper;

/**
 * {@inheritdoc}
 */
class Icon extends \yii\web\View {
	/**
	 * @var object default settings
	 */
	public $defaults;

	/**
	 * Construct.
	 */
	public function __construct() {
		parent::__construct();
		$this->defaults = new Defaults();
	}

	/**
	 * Outputs the SVG string.
	 * @param string $name Name of the icon
	 * @param array $options Optional options for the icon
	 */
	public function show(string $name, array $options = []): string {
		ArrayHelper::setValue($options, 'name', $name);

		$svg = new Svg($this->defaults);
		return $svg->getSvg($options);
	}

	/**
	 * Returns the ActiveField inputTemplate.
	 * @param string $name Name of the icon
	 * @param array $options Optional options for the field and the icon
	 * @return string ActiveField icon with proper code
	 */
	public function activeFieldAddon(string $name, array $options = []): string {
		$Html = "thoulah\\fontawesome\\{$this->defaults->bootstrap}\\Html";
		$groupSize = ArrayHelper::remove($options, 'groupSize', $this->defaults->groupSize);

		$append = ArrayHelper::getValue($options, 'append', $this->defaults->append);
		$icon = $Html::activeFieldAddon($groupSize, $append);
		return str_replace('{icon}', $this->activeFieldIcon($name, $options), $icon);
	}

	/**
	 * Returns the ActiveField Icon.
	 * @param string $name Name of the icon
	 * @param array $options Optional options for the field and the icon
	 */
	public function activeFieldIcon(string $name, array $options = []): string {
		$Html = "thoulah\\fontawesome\\{$this->defaults->bootstrap}\\Html";

		$append = ArrayHelper::remove($options, 'append', $this->defaults->append);
		$icon = $Html::activeFieldIcon($append);
		return str_replace('{icon}', $this->show($name, $options), $icon);
	}
}
