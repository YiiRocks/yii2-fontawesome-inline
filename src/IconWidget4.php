<?php

/**
 * @link https://fontawesome.mr42.me/
 * @license https://github.com/Thoulah/yii2-fontawesome-inline/blob/master/LICENSE
 */

namespace thoulah\fontawesome;

use thoulah\fontawesome\config\Defaults;
use yii\helpers\ArrayHelper;

/**
 * IconWidget provides an easy way to access Font Awesome icons using Widget.
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
    /**
     * @var Defaults the default settings
     */
    public static $defaults;

    /**
     * @var string name of the icon
     */
    public $name;

    /**
     * @var array icon settings
     */
    public $options = [];

    /**
     * Init.
     */
    public function init(): void
    {
        $defaults = ArrayHelper::toArray(static::$defaults);
        static::$defaults = new Defaults($defaults);
        parent::init();
    }

    /**
     * Construct.
     */
    public function run(): string
    {
        ArrayHelper::setValue($this->options, 'name', $this->name);

        $svg = new Svg(static::$defaults);
        return $svg->getSvg($this->options);
    }
}
