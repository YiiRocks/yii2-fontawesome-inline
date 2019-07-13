<?php
namespace thoulah\fontawesome\helpers;

use thoulah\fontawesome\assets\FontAwesomeAsset;
use thoulah\fontawesome\config\Defaults;
use thoulah\fontawesome\config\Options;
use Yii;

/**
 * Helper class to load and manipulate images
 */
class Image
{
    /** @var Defaults default options */
    private $_defaults;

    /** @var object image data */
    private $_image;

    /** @var Options individual icon options */
    private $_options;

    /** @var string result of {@see Defaults} and {@see Options} validation */
    private $_validation;

    /**
     * Creates a new Image object
     *
     * @param Defaults $defaults default options
     */
    public function __construct(Defaults $defaults)
    {
        $this->_defaults = $defaults;
        $this->_validation = $this->_defaults->validate();

        if ($this->_defaults->registerAssets) {
            FontAwesomeAsset::register(Yii::$app->getView());
        }
    }

    /**
     * Magic function, returns the image string.
     *
     * @return string The SVG result
     */
    public function __toString(): string
    {
        return $this->_validation . (string) $this->_image;
    }

    /**
     * Load and process image
     *
     * @param array $options options
     * @return Svg Processed image data
     */
    public function get(array $options): Svg
    {
        $this->_options = new Options($options);
        $this->_validation .= $this->_options->validate();

        return $this->getSvg();
    }

    /**
     * Load and process SVG data in correct order
     *
     * @return Svg Processed SVG data
     */
    private function getSvg(): Svg
    {
        $this->_image = new Svg($this->_defaults, $this->_options);
        $this->_image->load();
        $this->_image->getMeasurement();
        $this->_image->getProperties();
        $this->_image->setAttributes();

        return $this->_image;
    }
}
