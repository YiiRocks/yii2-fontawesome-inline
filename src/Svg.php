<?php
namespace thoulah\fontawesome;

use DOMDocument;
use thoulah\fontawesome\config\Defaults;
use thoulah\fontawesome\config\Options;
use Yii;
use yii\helpers\ArrayHelper;

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
     * Construct.
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
        $this->_options = $options;
        $options = new Options();

        $this->_validation .= $options->validate($this->_options);

        $this->load();
        $this->setTitle();
        $this->setSvgSize();
        $this->setProperties();
        return $this;
    }

    /**
     * Load Font Awesome SVG file. Falls back to default if not found.
     * @see Defaults::$fallbackIcon
     */
    private function load(): void
    {
        $fontAwesomeFolder = ArrayHelper::remove($this->_options, 'fontAwesomeFolder', $this->_defaults->fontAwesomeFolder);
        $style = ArrayHelper::remove($this->_options, 'style', $this->_defaults->style);
        $name = ArrayHelper::remove($this->_options, 'name');

        $fileName = (is_file(Yii::getAlias($name)))
            ? $name
            : implode(DIRECTORY_SEPARATOR, [$fontAwesomeFolder, $style, "{$name}.svg"]);

        if ($fileName === $name) {
            $this->_isCustomFile = true;
        } elseif (!is_file(Yii::getAlias($fileName))) {
            $fileName = $this->_defaults->fallbackIcon;
        }

        $this->_svg->load(Yii::getAlias($fileName));
        $this->_svgElement = $this->_svg->getElementsByTagName('svg')->item(0);
    }

    /**
     * Prepares and adds the SVG data.
     */
    private function setProperties(): void
    {
        $Html = __NAMESPACE__ . "\\{$this->_defaults->bootstrap}\\Html";

        ArrayHelper::setValue($this->_options, 'aria-hidden', 'true');
        ArrayHelper::setValue($this->_options, 'role', 'img');

        if (ArrayHelper::remove($this->_options, 'fixedWidth')) {
            $Html::addCssClass($this->_options, $this->_defaults->prefix . '-fw');
        }

        $fill = ArrayHelper::remove($this->_options, 'fill', $this->_defaults->fill);
        if (!empty($fill)) {
            foreach ($this->_svg->getElementsByTagName('path') as $path) {
                $path->setAttribute('fill', $fill);
            }
        }

        foreach ($this->_options as $key => $value) {
            $this->_svgElement->setAttribute($key, $value);
        }
    }

    /**
     * Sets either the size class (default) or the width/height if height is given manually.
     */
    private function setSvgSize(): void
    {
        $Html = __NAMESPACE__ . "\\{$this->_defaults->bootstrap}\\Html";
        [$xStart, $yStart, $xEnd, $yEnd] = explode(' ', $this->_svgElement->getAttribute('viewBox'));
        $svgWidth = $xEnd - $xStart;
        $svgHeight = $yEnd - $yStart;

        $height = ArrayHelper::remove($this->_options, 'height', 0);
        if ($height === 0) {
            if (!$this->_isCustomFile) {
                $Html::addCssClass($this->_options, $this->_defaults->prefix);
                $Html::addCssClass($this->_options, $this->_defaults->prefix . '-w-' . ceil($svgWidth / $svgHeight * 16));
            }
            return;
        }

        ArrayHelper::setValue($this->_options, 'width', round($height * $svgWidth / $svgHeight));
        ArrayHelper::setValue($this->_options, 'height', $height);
    }

    /**
     * Sets the title.
     */
    private function setTitle(): void
    {
        if ($title = ArrayHelper::remove($this->_options, 'title')) {
            $this->_svgElement->insertBefore($this->_svg->createElement('title', $title), $this->_svgElement->firstChild);
        }
    }
}
