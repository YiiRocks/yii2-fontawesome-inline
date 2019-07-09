<?php
namespace thoulah\fontawesome\helpers;

use thoulah\fontawesome\assets\FontAwesomeAsset;
use thoulah\fontawesome\config\Defaults;
use thoulah\fontawesome\config\Options;
use thoulah\fontawesome\dom\DOMDocument;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Helper class to load and manipulate SVG data
 */
class Svg
{
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

    /** @var \DOMElement extracted SVG element from [[$_svg]] */
    private $_svgElement;

    /** @var array additional properties for the icon not set with Options */
    private $_svgProperties;

    /** @var string result of {@see Defaults} and {@see Options} validation */
    private $_validation;

    /**
     * Creates a new Svg object
     *
     * @param Defaults $defaults default options
     */
    public function __construct(Defaults $defaults)
    {
        $this->_svg = new DOMDocument();
        $this->_defaults = new Defaults();

        foreach ($defaults as $key => $value) {
            $this->_defaults->$key = $value;
        }

        $this->_validation = $this->_defaults->validate();

        if ($this->_defaults->registerAssets) {
            FontAwesomeAsset::register(Yii::$app->getView());
        }
    }

    /**
     * Magic function, returns the SVG string.
     *
     * @return string The SVG result
     */
    public function __toString(): string
    {
        return $this->_validation . $this->_svg->saveXML($this->_svgElement);
    }

    /**
     * Load and process SVG data in correct order
     *
     * @param array $options options
     * @return self Processed SVG data
     */
    public function getSvg(array $options): self
    {
        $this->_options = new Options($options);
        $this->_validation .= $this->_options->validate();

        $class = $this->_options->removeValue('class');
        $this->_class = (is_array($class)) ? $class : ['class' => $class];

        $this->getFile();
        $this->getMeasurement();
        $this->getProperties();
        $this->setAttributes();
        return $this;
    }

    /**
     * Load Font Awesome SVG file. Falls back to default if not found.
     *
     * @see Defaults::$fallbackIcon
     */
    private function getFile(): void
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
     * Prepares either the size class (default) or the width/height if height is given manually.
     */
    private function getMeasurement(): void
    {
        if ($this->_svgElement->hasAttribute('width') && $this->_svgElement->hasAttribute('height')) {
            $svgWidth = $this->_svgElement->getAttribute('width');
            $svgHeight = $this->_svgElement->getAttribute('height');
        } elseif ($this->_svgElement->hasAttribute('viewBox')) {
            [$xStart, $yStart, $xEnd, $yEnd] = explode(' ', $this->_svgElement->getAttribute('viewBox'));
            $svgWidth = $xEnd - $xStart;
            $svgHeight = $yEnd - $yStart;
        }

        if (isset($svgWidth, $svgHeight)) {
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
    }

    /**
     * Prepares the values to be set on the SVG.
     */
    private function getProperties(): void
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
     * Adds the properties to the SVG.
     */
    private function setAttributes(): void
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
}
