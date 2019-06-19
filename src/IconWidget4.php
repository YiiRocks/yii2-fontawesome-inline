<?php
namespace thoulah\fontawesome;

use yii\helpers\ArrayHelper;

class IconWidget4 extends \yii\bootstrap4\Widget {
	public static $defaults = [];
	public $name;
	public $options = [];

	/*
	 *  Initialize
	 */
	public function init() {
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
