<?php
/**
 *  @link https://fontawesome.mr42.me/
 *  @license https://github.com/Thoulah/yii2-fontawesome-inline/blob/master/LICENSE
 */

namespace thoulah\fontawesome;

use DOMDocument;
use Yii;
use yii\helpers\ArrayHelper;

class Svg {
	private $svg;
	private $svgElement;
	private $defaults;
	private $options;
	private $validation;

	/**
	 *	Construct.
	 */
	public function __construct(Options $defaults) {
		$this->svg = new DOMDocument();
		$this->defaults = new Options();

		foreach ($defaults as $key => $value) {
			$this->defaults->$key = $value;
		}

		$this->validation = $this->defaults->validateDefaults();

		if ($this->defaults->registerAssets) {
			FontAwesomeAsset::register(Yii::$app->getView());
		}
	}

	/**
	 *  Magic function, returns the SVG string.
	 */
	public function __toString(): string {
		return $this->validation . $this->svg->saveXML($this->svgElement);
	}

	public function getSvg(array $options): string {
		$this->options = $options;

		$this->validation .= $this->defaults->validateOptions($this->options);

		$this->load();
		$this->setTitle();
		$this->setSvgSize();
		$this->setProperties();
		return $this;
	}

	/**
	 *  Load Font Awesome SVG file. Falls back to defaults if not found.
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
		$this->svgElement = $this->svg->getElementsByTagName('svg')->item(0);
	}

	/**
	 *  Sets the title.
	 */
	private function setTitle(): void {
		if ($title = ArrayHelper::remove($this->options, 'title')) {
			$this->svgElement->insertBefore($this->svg->createElement('title', $title), $this->svgElement->firstChild);
		}
	}

	/**
	 *  Prepares and adds the SVG data.
	 */
	private function setProperties(): void {
		$Html = __NAMESPACE__ . "\\{$this->defaults->bootstrap}\\Html";

		ArrayHelper::setValue($this->options, 'aria-hidden', 'true');
		ArrayHelper::setValue($this->options, 'role', 'img');

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
			$this->svgElement->setAttribute($key, $value);
		}
	}

	/**
	 *  Sets either the size class (default) or the width/height if height is given manually.
	 */
	private function setSvgSize(): void {
		$Html = __NAMESPACE__ . "\\{$this->defaults->bootstrap}\\Html";
		[$xStart, $yStart, $xEnd, $yEnd] = explode(' ', $this->svgElement->getAttribute('viewBox'));
		$svgWidth = $xEnd - $xStart;
		$svgHeight = $yEnd - $yStart;

		$height = ArrayHelper::remove($this->options, 'height', 0);
		if ($height === 0) {
			$Html::addCssClass($this->options, $this->defaults->prefix);
			$Html::addCssClass($this->options, $this->defaults->prefix . '-w-' . ceil($svgWidth / $svgHeight * 16));
			return;
		}

		ArrayHelper::setValue($this->options, 'width', round($height * $svgWidth / $svgHeight));
		ArrayHelper::setValue($this->options, 'height', $height);
	}
}
