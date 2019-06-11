<?php
namespace thoulah\fontawesome;

use yii\helpers\ArrayHelper;

class IconWidget extends \yii\bootstrap4\Widget {
	public static $default = [];
	public $svg;
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
	 *  Primary function. Outputs the SVG string
	 */
	public function run(): string {
		$options = new Options();
		$validationOutput = $options->validate($this->options);

		$svg = new Svg();
		$svg->default = (object) ArrayHelper::merge((array) $options, static::$default);

		$fontAwesomeFolder = ArrayHelper::remove($this->options, 'fontAwesomeFolder', $svg->default->fontAwesomeFolder);
		$style = ArrayHelper::remove($this->options, 'style', $svg->default->defaultStyle);

		$iconString = $svg->load("{$fontAwesomeFolder}/{$style}/{$this->name}.svg");
		return $validationOutput.$svg->process($iconString, $this->options);
	}
}
