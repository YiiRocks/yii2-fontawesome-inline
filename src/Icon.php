<?php
namespace thoulah\fontawesome;

use DOMDocument;
use Yii;
use yii\bootstrap4\Html;
use yii\helpers\ArrayHelper;

class Icon extends \yii\bootstrap4\Widget {
	public $inputGroupClass = ['input-group'];
	public $fallbackIcon = '@bower/fontawesome/svgs/solid/question-circle.svg';
	public $prefix = 'svg-inline--fa';

	/*
	 *  Register CSS automatically on load
	 */
	public function __construct() {
		FontAwesomeAsset::register($this->getView());
	}

	/*
	 *  Primary function. Outputs the SVG string
	 */
	public function show(string $name, array $options = []): string {
		$style = ArrayHelper::remove($options, 'style', 'solid');
		$svg = $this->loadSvg("@bower/fontawesome/svgs/{$style}/{$name}.svg");
		return $this->processSvg($svg, $options);
	}

	/*
	 *  Return the complete ActiveField inputTemplate
	 */
	public function activeFieldAddon(string $name, array $options = []): string {
		$direction = ArrayHelper::getValue($options, 'direction', 'prepend');
		$groupsize = ArrayHelper::remove($options, 'groupsize');

		if ($groupsize)
			Html::addCssClass($this->inputGroupClass, "input-group-{$groupsize}");

		return Html::tag('div',
			($direction === 'prepend')
				? $this->activeFieldIcon($name, $options).'{input}'
				: '{input}'.$this->activeFieldIcon($name, $options)
		, ['class' => $this->inputGroupClass]);
	}

	/*
	 *  Return the partial ActiveField inputTemplate for manual use
	 */
	public function activeFieldIcon(string $name, array $options = []): string {
		Html::addCssClass($options, $this->prefix.'-fw');
		$direction = ArrayHelper::remove($options, 'direction', 'prepend');

		$icon = Html::tag('div', $this->show($name, $options), ['class' => 'input-group-text']);
		return Html::tag('div', $icon, ['class' => "input-group-{$direction}"]);
	}

	/*
	 *  Load Font Awesome SVG file. Falls back to default if not found
	 *  @see $fallbackIcon
	 */
	protected function loadSvg(string $fileName): DOMDocument {
		if (!is_file(Yii::getAlias($fileName)))
			$fileName = $this->fallbackIcon;

		$doc = new DOMDocument();
		$doc->load(Yii::getAlias($fileName));
		return $doc;
	}

	/*
	 *  Prepares and adds the SVG data
	 */
	protected function processSvg(DOMDocument $doc, array $options): string {
		ArrayHelper::setValue($options, 'aria-hidden', 'true');
		ArrayHelper::setValue($options, 'role', 'img');

		// loading the SVG data
		$svg = $doc->getElementsByTagName('svg')->item(0);

		// adding title tag
		if ($title = ArrayHelper::remove($options, 'title'))
			$svg->appendChild($doc->createElement('title', $title));

		// dimension dependent class. This is overruled if height is given manually
		[,, $svgWidth, $svgHeight] = explode(' ', $svg->getAttribute('viewBox'));
		switch ($height = ArrayHelper::getValue($options, 'height', 0)) :
			case 0:
				Html::addCssClass($options, $this->prefix);
				Html::addCssClass($options, $this->prefix.'-w-'.ceil($svgWidth / $svgHeight * 16));
				break;
			default:
				ArrayHelper::setValue($options, 'width', round($height * $svgWidth / $svgHeight));
		endswitch;

		// Fill for every path, unless set to false
		if ($fill = ArrayHelper::remove($options, 'fill', 'currentColor'))
			foreach ($doc->getElementsByTagName('path') as $path)
				$path->setAttribute('fill', $fill);

		// copy all options to svg tag
		foreach ($options as $key => $value)
			$svg->setAttribute($key, $value);

		return $doc->saveXML($svg);
	}
}
