<?php

namespace thoulah\fontawesome;

use thoulah\fontawesome\config\Defaults;
use thoulah\fontawesome\helpers\Image;

/**
 * Provides an easy way to access icons as a widget.
 *
 * ```php
 * use thoulah\fontawesome\IconWidget4 as IconWidget;
 * echo IconWidget::widget(['name' => 'at']);
 *
 * echo IconWidget::widget([
 *     'name' => 'github',
 *     'options' => [
 *         'style' => 'brands',
 *         'fill' => '#003865'
 *     ]
 * ]);
 *
 * echo IconWidget::widget([
 *     'name' => 'font-awesome',
 *     'options' => [
 *         'class' => 'yourClass',
 *         'style' => 'brands'
 *     ],
 * ]);
 * ```
 */
class IconWidget4 extends \yii\bootstrap4\Widget
{
    /** @var array|null overrides of the default settings */
    public static $defaults;

    /** @var string name of the icon */
    public $name;

    /** @var array icon settings */
    public $options = [];

    /**
     * Executes the widget.
     *
     * @return string The icon
     */
    public function run(): string
    {
        $defaults = new Defaults(static::$defaults ?? []);
        $image = new Image($defaults);

        $this->options['name'] = $this->name;

        return $image->get($this->options);
    }
}
