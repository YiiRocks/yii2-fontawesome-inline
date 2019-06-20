<?php
/**
 *  @link https://thoulah.mr42.me/fontawesome
 *  @license https://github.com/Thoulah/yii2-fontawesome-inline/blob/master/LICENSE
 */

namespace thoulah\fontawesome;

use yii\helpers\ArrayHelper;

class IconWidget4 extends \yii\bootstrap4\Widget {
	public static $defaults = [];
	public $name;
	public $options = [];

	/*
	 *  Initialize
	 */
	public function init(): void {
		parent::init();
		FontAwesomeAsset::register($this->getView());
	}

	/*
	 *  Outputs the SVG string
	 */
	public function run(): string {
		ArrayHelper::setValue($this->options, 'name', $this->name);

		$svg = new Svg(static::$defaults);
		return $svg->getString($this->options);
	}
}
