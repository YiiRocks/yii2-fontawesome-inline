<?php

namespace thoulah\fontawesome\helpers;

use thoulah\fontawesome\assets\FontAwesomeAsset;
use thoulah\fontawesome\config\Defaults;
use thoulah\fontawesome\config\Options;
use Yii;

/**
 * Helper class to load and manipulate images.
 */
class Image
{
    /** @var Defaults default options */
    private $defaults;

    /** @var object image data */
    private $image;

    /** @var Options individual icon options */
    private $options;

    /** @var string result of {@see Defaults} and {@see Options} validation */
    private $validation;

    /**
     * Creates a new Image object.
     *
     * @param Defaults $defaults default options
     */
    public function __construct(Defaults $defaults)
    {
        $this->defaults = $defaults;
        $this->validation = $this->defaults->validate();

        if ($this->defaults->registerAssets) {
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
        return $this->validation . (string) $this->image;
    }

    /**
     * Load and process image.
     *
     * @param array $options options
     *
     * @return Svg Processed image data
     */
    public function get(array $options): Svg
    {
        $this->options = new Options($options);
        $this->validation .= $this->options->validate();

        return $this->getSvg();
    }

    /**
     * Load and process SVG data in correct order.
     *
     * @return Svg Processed SVG data
     */
    private function getSvg(): Svg
    {
        $this->image = new Svg($this->defaults, $this->options);
        $this->image->load();
        $this->image->getMeasurement();
        $this->image->getProperties();
        $this->image->setAttributes();

        return $this->image;
    }
}
