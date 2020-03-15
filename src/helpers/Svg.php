<?php

namespace thoulah\fontawesome\helpers;

use thoulah\fontawesome\config\Defaults;
use thoulah\fontawesome\config\Options;
use yii\helpers\Html;

/**
 * SVG helper.
 */
class Svg
{
    /** @var array values for converting various units to pixels */
    private const PIXEL_MAP = [
        'px' => 1,
        'em' => 16,
        'ex' => 16 / 2,
        'pt' => 16 / 12,
        'pc' => 16,
        'in' => 16 * 6,
        'cm' => 16 / (2.54 / 6),
        'mm' => 16 / (25.4 / 6),
    ];

    /** @var array class property */
    private $class;

    /** @var Defaults default options */
    private $defaults;

    /** @var bool `true` if name resolves to a valid XML file */
    private $isCustomFile = false;

    /** @var Options individual icon options */
    private $options;

    /** @var DOMDocument SVG file */
    private $svg;

    /** @var \DOMNode SVG */
    private $svgElement;

    /** @var array additional properties for the icon not set with Options */
    private $svgProperties;

    /**
     * Construct.
     *
     * @param Defaults $defaults default options
     * @param Options  $options  individual icon options
     */
    public function __construct(Defaults $defaults, Options $options)
    {
        $this->svg = new DOMDocument();
        $this->defaults = $defaults;
        $this->options = $options;

        $class = $this->options->removeValue('class');
        $this->class = (is_array($class)) ? $class : ['class' => $class];
    }

    /**
     * Magic function, returns the SVG string.
     *
     * @return string The SVG result
     */
    public function __toString(): string
    {
        return $this->svg->saveXML($this->svgElement);
    }

    /**
     * Prepares either the size class (default) or the width/height if either of these is given manually.
     */
    public function getMeasurement(): void
    {
        [$svgWidth, $svgHeight] = $this->getSize();

        $width = $this->options->removeValue('width');
        $height = $this->options->removeValue('height');
        $addClass = $this->options->removeValue('addClass');
        if ($width || $height) {
            $this->svgProperties['width'] = $width ?? round($height * $svgWidth / $svgHeight);
            $this->svgProperties['height'] = $height ?? round($width * $svgHeight / $svgWidth);
        } elseif (!$this->isCustomFile || ($this->isCustomFile && $addClass)) {
            Html::addCssClass($this->class, $this->defaults->prefix);
            Html::addCssClass($this->class, $this->defaults->prefix . '-w-' . ceil($svgWidth / $svgHeight * 16));
        }
    }

    /**
     * Prepares the values to be set on the SVG.
     */
    public function getProperties(): void
    {
        $this->svgProperties['aria-hidden'] = 'true';
        $this->svgProperties['role'] = 'img';

        if ($this->options->removeValue('fixedWidth')) {
            Html::addCssClass($this->class, $this->defaults->prefix . '-fw');
        }

        if ($this->class['class']) {
            $this->svgProperties['class'] = $this->class['class'];
        }

        if (!empty($this->options->css)) {
            $css = $this->options->removeValue('css', []);
            $this->svgProperties['style'] = Html::cssStyleFromArray($css);
        }

        $this->svgProperties['fill'] = $this->options->removeValue('fill', $this->defaults->fill);
    }

    /**
     * Load Font Awesome SVG file. Falls back to default if not found.
     *
     * @see Defaults::$fallbackIcon
     */
    public function load(): void
    {
        $fontAwesomeFolder = $this->options->removeValue('fontAwesomeFolder', $this->defaults->fontAwesomeFolder);
        $style = $this->options->removeValue('style', $this->defaults->style);
        $name = $this->options->removeValue('name');
        $fileName = implode(DIRECTORY_SEPARATOR, [$fontAwesomeFolder, $style, "{$name}.svg"]);

        if ($this->svg->load($name)) {
            $this->isCustomFile = true;
        } elseif (!$this->svg->load($fileName)) {
            $this->svg->load($this->defaults->fallbackIcon);
        }

        $this->svgElement = $this->svg->getElementsByTagName('svg')->item(0);
    }

    /**
     * Adds the properties to the SVG.
     */
    public function setAttributes(): void
    {
        if ($this->options->title) {
            $title = $this->options->removeValue('title');
            $titleElement = $this->svg->createElement('title', $title);
            $this->svgElement->insertBefore($titleElement, $this->svgElement->firstChild);
        }

        foreach ([$this->options, $this->svgProperties] as $data) {
            foreach ($data as $key => $value) {
                if (!empty($value)) {
                    $this->svgElement->setAttribute($key, $value);
                }
            }
        }
    }

    /**
     * Converts various sizes to pixels.
     *
     * @param string $size
     *
     * @return int
     */
    private function getPixelValue(string $size): int
    {
        $size = trim($size);
        $value = substr($size, 0, -2);
        $unit = substr($size, -2);

        if (is_numeric($value) && isset(self::PIXEL_MAP[$unit])) {
            $size = $value * self::PIXEL_MAP[$unit];
        }

        return (int) round((float) $size);
    }

    /**
     * Determines size of the SVG element.
     *
     * @return array Width & height
     */
    private function getSize(): array
    {
        $svgWidth = $this->getPixelValue($this->svgElement->getAttribute('width'));
        $svgHeight = $this->getPixelValue($this->svgElement->getAttribute('height'));

        [$xStart, $yStart, $xEnd, $yEnd] = explode(' ', $this->svgElement->getAttribute('viewBox') ?: '');
        $viewBoxWidth = isset($xStart, $xEnd) ? $xEnd - $xStart : 0;
        $viewBoxHeight = isset($yStart, $yEnd) ? $yEnd - $yStart : 0;

        if ($viewBoxWidth > 0 && $viewBoxHeight > 0) {
            $svgWidth = $viewBoxWidth;
            $svgHeight = $viewBoxHeight;
        }

        return [$svgWidth ?? 1, $svgHeight ?? 1];
    }
}
