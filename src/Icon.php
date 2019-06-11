<?php
namespace thoulah\fontawesome;

use yii\bootstrap4\Html;
use yii\helpers\ArrayHelper;

class Icon extends \yii\web\View {
	public $default;

	/*
	 *  Initialize
	 */
	public function __construct() {
		parent::__construct();
		$this->default = new Options();
		$this->registerAssetBundle(FontAwesomeAsset::class);
	}

	/*
	 *  Primary function. Outputs the SVG string
	 */
	public function show(string $name, array $options = []): string {
		$opt = new Options();
		$validationOutput = $opt->validate($options);

		$fontAwesomeFolder = ArrayHelper::remove($options, 'fontAwesomeFolder', $this->default->fontAwesomeFolder);
		$style = ArrayHelper::remove($options, 'style', $this->default->defaultStyle);

		$svg = new Svg();
		$svg->default = $this->default;
		$iconString = $svg->load("{$fontAwesomeFolder}/{$style}/{$name}.svg");
		return $validationOutput.$svg->process($iconString, $options);
	}

	/*
	 *  Return the complete ActiveField inputTemplate
	 */
	public function activeFieldAddon(string $name, array $options = []): string {
		$inputGroupClass = ['input-group'];
		$groupSize = ArrayHelper::remove($options, 'groupSize', $this->default->defaultGroupSize);
		if ($groupSize !== 'md')
			Html::addCssClass($inputGroupClass, "input-group-{$groupSize}");

		return Html::tag('div',
			(ArrayHelper::getValue($options, 'append', $this->default->defaultAppend))
				? '{input}'.$this->activeFieldIcon($name, $options)
				: $this->activeFieldIcon($name, $options).'{input}'
		, ['class' => $inputGroupClass]);
	}

	/*
	 *  Return the partial ActiveField inputTemplate for manual use
	 */
	public function activeFieldIcon(string $name, array $options = []): string {
		if (!isset($options['fixedWidth']))
			ArrayHelper::setValue($options, 'fixedWidth', true);

		$icon = Html::tag('div', $this->show($name, $options), ['class' => 'input-group-text']);
		$direction = (ArrayHelper::remove($options, 'append', $this->default->defaultAppend)) ? 'append' : 'prepend';
		return Html::tag('div', $icon, ['class' => "input-group-{$direction}"]);
	}
}
