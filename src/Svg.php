<?php
namespace thoulah\fontawesome;

use DOMDocument;
use Yii;
use yii\bootstrap4\Html;
use yii\helpers\ArrayHelper;

class Svg {
	public $default;

	/*
	 *  Load Font Awesome SVG file. Falls back to default if not found
	 *  @see $fallbackIcon
	 */
	public function load(string $fileName): DOMDocument {
		if (!is_file(Yii::getAlias($fileName)))
			$fileName = $this->default->fallbackIcon;

		$doc = new DOMDocument();
		$doc->load(Yii::getAlias($fileName));
		return $doc;
	}

	/*
	 *  Prepares and adds the SVG data
	 */
	public function process(DOMDocument $doc, array $options): string {
		ArrayHelper::setValue($options, 'aria-hidden', 'true');
		ArrayHelper::setValue($options, 'role', 'img');

		// Picking the SVG data
		$svg = $doc->getElementsByTagName('svg')->item(0);

		// Adding the (optional) title tag
		if ($title = ArrayHelper::remove($options, 'title'))
			$svg->appendChild($doc->createElement('title', $title));

		// Adding dimension dependent class.
		// This is skipped if height is given manually, but then width is calculated and added
		[,, $svgWidth, $svgHeight] = explode(' ', $svg->getAttribute('viewBox'));
		switch ($height = ArrayHelper::getValue($options, 'height', 0)) :
			case 0:
				Html::addCssClass($options, $this->default->prefix);
				Html::addCssClass($options, $this->default->prefix.'-w-'.ceil($svgWidth / $svgHeight * 16));
				break;
			default:
				ArrayHelper::setValue($options, 'width', round($height * $svgWidth / $svgHeight));
		endswitch;

		// Fixed width
		if (ArrayHelper::remove($options, 'fixedWidth'))
			Html::addCssClass($options, $this->default->prefix.'-fw');

		// Optional fill colour for every path
		$fill = ArrayHelper::remove($options, 'fill', $this->default->defaultFill);
		if (!empty($fill))
			foreach ($doc->getElementsByTagName('path') as $path)
				$path->setAttribute('fill', $fill);

		// Copy all options to the SVG tag
		foreach ($options as $key => $value)
			$svg->setAttribute($key, $value);

		// Return SVG data as string
		return $doc->saveXML($svg);
	}
}
