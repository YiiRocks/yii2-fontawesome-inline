<?php
namespace thoulah\fontawesome;

use DOMDocument;
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
	public function __construct($defaults) {
		$this->svg = new DOMDocument();
		$options = new Options();
		$this->defaults = (object) ArrayHelper::merge((array) $options, $defaults);
		$this->validation = $options->validateDefaults($this->defaults);
	}

	public function getString($options): string {
		$this->options = $options;
		$options = new Options();
		$this->validation .= $options->validateOptions($this->options);

		$this->load();
		return $this->validation.$this->process();
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
		if (!is_file(Yii::getAlias($fileName)))
			$fileName = $this->defaults->fallbackIcon;

		$this->svg->load(Yii::getAlias($fileName));
	}

	/*
	 *  Prepares and adds the SVG data
	 */
	private function process(): string {
		$Html = __NAMESPACE__."\\{$this->defaults->bootstrap}\\Html";
		ArrayHelper::setValue($this->options, 'aria-hidden', 'true');
		ArrayHelper::setValue($this->options, 'role', 'img');

		$svg = $this->svg->getElementsByTagName('svg')->item(0);
		if ($title = ArrayHelper::remove($this->options, 'title'))
			$svg->appendChild($this->svg->createElement('title', $title));

		[,, $svgWidth, $svgHeight] = explode(' ', $svg->getAttribute('viewBox'));
		switch ($height = ArrayHelper::getValue($this->options, 'height', 0)) :
			case 0:
				$Html::addCssClass($this->options, $this->defaults->prefix);
				$Html::addCssClass($this->options, $this->defaults->prefix.'-w-'.ceil($svgWidth / $svgHeight * 16));
				break;
			default:
				ArrayHelper::setValue($this->options, 'width', round($height * $svgWidth / $svgHeight));
		endswitch;

		if (ArrayHelper::remove($this->options, 'fixedWidth'))
			$Html::addCssClass($this->options, $this->defaults->prefix.'-fw');

		$fill = ArrayHelper::remove($this->options, 'fill', $this->defaults->fill);
		if (!empty($fill))
			foreach ($this->svg->getElementsByTagName('path') as $path)
				$path->setAttribute('fill', $fill);

		foreach ($this->options as $key => $value)
			$svg->setAttribute($key, $value);

		return $this->svg->saveXML($svg);
	}
}
