<?php
namespace thoulah\fontawesome\helpers;

use thoulah\fontawesome\config\Defaults;
use thoulah\fontawesome\config\Options;
use yii\helpers\Html;

/**
 * SVG helper
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
    private $_class;

    /** @var Defaults default options */
    private $_defaults;

    /** @var bool `true` if name resolves to a valid XML file */
    private $_isCustomFile = false;

    /** @var Options individual icon options */
    private $_options;

    /** @var DOMDocument SVG file */
    private $_svg;

    /** @var \DOMNode SVG */
    private $_svgElement;

    /** @var array additional properties for the icon not set with Options */
    private $_svgProperties;

    /**
     * Construct.
     *
     * @param Defaults $defaults default options
     * @param Options $options individual icon options
     */
    public function __construct(Defaults $defaults, Options $options)
    {
        $this->_svg = new DOMDocument();
        $this->_defaults = $defaults;
        $this->_options = $options;

        $class = $this->_options->removeValue('class');
        $this->_class = (is_array($class)) ? $class : ['class' => $class];
    }

    /**
     * Magic function, returns the SVG string.
     *
     * @return string The SVG result
     */
    public function __toString(): string
    {
        return $this->_svg->saveXML($this->_svgElement);
    }

    /**
     * Prepares either the size class (default) or the width/height if either of these is given manually.
     */
    public function getMeasurement(): void
    {
        [$svgWidth, $svgHeight] = $this->getSize();

        $width = $this->_options->removeValue('width');
        $height = $this->_options->removeValue('height');
        if ($width || $height) {
            $this->_svgProperties['width'] = $width ?? round($height * $svgWidth / $svgHeight);
            $this->_svgProperties['height'] = $height ?? round($width * $svgHeight / $svgWidth);
        } elseif (!$this->_isCustomFile) {
            Html::addCssClass($this->_class, $this->_defaults->prefix);
            Html::addCssClass($this->_class, $this->_defaults->prefix . '-w-' . ceil($svgWidth / $svgHeight * 16));
        }
    }

    /**
     * Prepares the values to be set on the SVG.
     */
    public function getProperties(): void
    {
        $this->_svgProperties['aria-hidden'] = 'true';
        $this->_svgProperties['role'] = 'img';

        if ($this->_options->removeValue('fixedWidth')) {
            Html::addCssClass($this->_class, $this->_defaults->prefix . '-fw');
        }

        if ($this->_class['class']) {
            $this->_svgProperties['class'] = $this->_class['class'];
        }

        if ($css = $this->_options->removeValue('css')) {
            $this->_svgProperties['style'] = Html::cssStyleFromArray($css);
        }

        if ($fill = $this->_options->removeValue('fill', $this->_defaults->fill)) {
            $this->_svgProperties['fill'] = $fill;
        }
    }

    /**
     * Load Font Awesome SVG file. Falls back to default if not found.
     *
     * @see Defaults::$fallbackIcon
     */
    public function load(): void
    {
        $fontAwesomeFolder = $this->_options->removeValue('fontAwesomeFolder', $this->_defaults->fontAwesomeFolder);
        $style = $this->_options->removeValue('style', $this->_defaults->style);
        $name = $this->_options->removeValue('name');
        $fileName = implode(DIRECTORY_SEPARATOR, [$fontAwesomeFolder, $style, "{$name}.svg"]);

        if ($this->_svg->load($name)) {
            $this->_isCustomFile = true;
        } elseif (!$this->_svg->load($fileName)) {
            $this->_svg->load($this->_defaults->fallbackIcon);
        }

        $this->_svgElement = $this->_svg->getElementsByTagName('svg')->item(0);
    }

    /**
     * Adds the properties to the SVG.
     */
    public function setAttributes(): void
    {
        if ($title = $this->_options->removeValue('title')) {
            $titleElement = $this->_svg->createElement('title', $title);
            $this->_svgElement->insertBefore($titleElement, $this->_svgElement->firstChild);
        }

        foreach ([$this->_options, $this->_svgProperties] as $data) {
            foreach ($data as $key => $value) {
                if (!empty($value)) {
                    $this->_svgElement->setAttribute($key, $value);
                }
            }
        }
    }

    /**
     * Converts various sizes to pixels.
     *
     * @param string $size
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
     * Determines size of the SVG element
     *
     * @return array Width & height
     */
    private function getSize(): array
    {
        $svgWidth = $this->getPixelValue($this->_svgElement->getAttribute('width'));
        $svgHeight = $this->getPixelValue($this->_svgElement->getAttribute('height'));

        [$xStart, $yStart, $xEnd, $yEnd] = explode(' ', $this->_svgElement->getAttribute('viewBox') ?: '');
        $viewBoxWidth = isset($xStart, $xEnd) ? $xEnd - $xStart : 0;
        $viewBoxHeight = isset($yStart, $yEnd) ? $yEnd - $yStart : 0;

        if ($viewBoxWidth > 0 && $viewBoxHeight > 0) {
            $svgWidth = $viewBoxWidth;
            $svgHeight = $viewBoxHeight;
        }

        return [$svgWidth ?? 1, $svgHeight ?? 1];
    }
}
