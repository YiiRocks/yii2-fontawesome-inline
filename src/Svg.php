<?php
/**
 *  @link https://fontawesome.mr42.me/
 *  @license https://github.com/Thoulah/yii2-fontawesome-inline/blob/master/LICENSE
 */

namespace thoulah\fontawesome;

use DOMDocument;
use DOMElement;
use Yii;
use yii\helpers\ArrayHelper;

class Svg {
	private $svg;
	private $defaults;
	private $options;
	private $validation;

	/*
	 *	Construct
	 */
	public function __construct(Options $defaults) {
		$this->svg = new DOMDocument();
		$this->defaults = new Options();

		foreach ($defaults as $key => $value) {
			$this->defaults->$key = $value;
		}

		$this->validation = $this->defaults->validateDefaults($this->defaults);

		if ($this->defaults->registerAssets) {
			FontAwesomeAsset::register(Yii::$app->getView());
		}
	}

	public function getString(array $options): string {
		$this->options = $options;

		$this->validation .= $this->defaults->validateOptions($this->options);

		$this->load();
		return $this->validation . $this->getSvg();
	}

	/*
	 *  Load Font Awesome SVG file. Falls back to defaults if not found
	 *  @see $fallbackIcon
	 */
	private function load(): void {
		$fontAwesomeFolder = ArrayHelper::remove($this->options, 'fontAwesomeFolder', $this->defaults->fontAwesomeFolder);
		$style = ArrayHelper::remove($this->options, 'style', $this->defaults->style);
		$name = ArrayHelper::remove($this->options, 'name');

		$fileName = "{$fontAwesomeFolder}/{$style}/{$name}.svg";
		if (!is_file(Yii::getAlias($fileName))) {
			$fileName = $this->defaults->fallbackIcon;
		}

		$this->svg->load(Yii::getAlias($fileName));
	}

	/*
	 *  Prepares and adds the SVG data
	 */
	private function getSvg(): string {
		$Html = __NAMESPACE__ . "\\{$this->defaults->bootstrap}\\Html";

		$svg = $this->svg->getElementsByTagName('svg')->item(0);
		if ($title = ArrayHelper::remove($this->options, 'title')) {
			$svg->appendChild($this->svg->createElement('title', $title));
		}

		ArrayHelper::setValue($this->options, 'aria-hidden', 'true');
		ArrayHelper::setValue($this->options, 'role', 'img');

		[$svgWidth, $svgHeight] = $this->getSvgSize($svg);
		switch ($height = ArrayHelper::getValue($this->options, 'height', 0)) {
			case 0:
				$Html::addCssClass($this->options, $this->defaults->prefix);
				$Html::addCssClass($this->options, $this->defaults->prefix . '-w-' . ceil($svgWidth / $svgHeight * 16));
				break;
			default:
				ArrayHelper::setValue($this->options, 'width', round($height * $svgWidth / $svgHeight));
		}

		if (ArrayHelper::remove($this->options, 'fixedWidth')) {
			$Html::addCssClass($this->options, $this->defaults->prefix . '-fw');
		}

		$fill = ArrayHelper::remove($this->options, 'fill', $this->defaults->fill);
		if (!empty($fill)) {
			foreach ($this->svg->getElementsByTagName('path') as $path) {
				$path->setAttribute('fill', $fill);
			}
		}

		foreach ($this->options as $key => $value) {
			$svg->setAttribute($key, $value);
		}

		return $this->svg->saveXML($svg);
	}

	/*
	 *  Return the width and height of the SVG from viewBox
	 */
	private function getSvgSize(DOMElement $svg): array {
		[$xStart, $yStart, $xEnd, $yEnd] = explode(' ', $svg->getAttribute('viewBox'));
		return [$xEnd - $xStart, $yEnd - $yStart];
	}
}
