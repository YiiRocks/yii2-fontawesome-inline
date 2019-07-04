<?php
namespace thoulah\fontawesome;

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
    /**
     * @var Defaults default options
     */
    private $_defaults;

    /**
     * @var string value of the `fill` attribute on the SVG paths
     */
    private $_fillColor;

    /**
     * @var bool `true` if filename was given manually
     */
    private $_isCustomFile = false;

    /**
     * @var array individual icon options
     */
    private $_options;

    /**
     * @var DOMDocument SVG file
     */
    private $_svg;

    /**
     * @var \DOMElement extracted SVG element from [[$_svg]]
     */
    private $_svgElement;

    /**
     * @var string Result op [[]] and [[]] validation
     */
    private $_validation;

    /**
     * Creates a new Svg object
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
     * @return string The SVG result
     */
    public function __toString(): string
    {
        return $this->_validation . $this->_svg->saveXML($this->_svgElement);
    }

    /**
     * Public function to load and process SVG data in correct order
     * @param array $options options
     * @return self Processed SVG data
     */
    public function getSvg(array $options): self
    {
        $this->_options = new Options($options);
        $this->_validation .= $this->_options->validate();
        $this->_options = ArrayHelper::toArray($this->_options);

        $this->getFile();
        $this->getMeasurement();
        $this->getProperties();
        $this->setAttributes();
        return $this;
    }

    /**
     * Load Font Awesome SVG file. Falls back to default if not found.
     * @see Defaults::$fallbackIcon
     */
    private function getFile(): void
    {
        $fontAwesomeFolder = ArrayHelper::remove($this->_options, 'fontAwesomeFolder', $this->_defaults->fontAwesomeFolder);
        $style = ArrayHelper::remove($this->_options, 'style', $this->_defaults->style);
        $name = ArrayHelper::remove($this->_options, 'name');
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
        [$xStart, $yStart, $xEnd, $yEnd] = explode(' ', $this->_svgElement->getAttribute('viewBox'));
        $svgWidth = $xEnd - $xStart;
        $svgHeight = $yEnd - $yStart;

        $height = ArrayHelper::remove($this->_options, 'height');
        if (!$height) {
            if (!$this->_isCustomFile) {
                Html::addCssClass($this->_options, $this->_defaults->prefix);
                Html::addCssClass($this->_options, $this->_defaults->prefix . '-w-' . ceil($svgWidth / $svgHeight * 16));
            }
            return;
        }

        ArrayHelper::setValue($this->_options, 'width', round($height * $svgWidth / $svgHeight));
        ArrayHelper::setValue($this->_options, 'height', $height);
    }

    /**
     * Prepares the values to be set on the SVG.
     */
    private function getProperties(): void
    {
        ArrayHelper::setValue($this->_options, 'aria-hidden', 'true');
        ArrayHelper::setValue($this->_options, 'role', 'img');

        if (ArrayHelper::remove($this->_options, 'fixedWidth')) {
            Html::addCssClass($this->_options, $this->_defaults->prefix . '-fw');
        }

        if ($css = ArrayHelper::remove($this->_options, 'css')) {
            $style = Html::cssStyleFromArray($css);
            ArrayHelper::setValue($this->_options, 'style', $style);
        }

        $this->_fillColor = ArrayHelper::remove($this->_options, 'fill', $this->_defaults->fill);
    }

    /**
     * Adds the properties to the SVG.
     */
    private function setAttributes(): void
    {
        if ($title = ArrayHelper::remove($this->_options, 'title')) {
            $this->_svgElement->insertBefore($this->_svg->createElement('title', $title), $this->_svgElement->firstChild);
        }

        foreach ($this->_options as $key => $value) {
            $this->_svgElement->setAttribute($key, $value);
        }

        if (!empty($this->_fillColor)) {
            foreach ($this->_svg->getElementsByTagName('path') as $path) {
                $path->setAttribute('fill', $this->_fillColor);
            }
        }
    }
}
