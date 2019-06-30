<?php
namespace thoulah\fontawesome;

use thoulah\fontawesome\config\Defaults;
use yii\helpers\ArrayHelper;

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
     * Initializes the object.
     */
    public function init(): void
    {
        $defaults = ArrayHelper::toArray(static::$defaults);
        static::$defaults = new Defaults($defaults);
        parent::init();
    }

    /**
     * Executes the widget.
     * @return string The icon
     */
    public function run(): string
    {
        ArrayHelper::setValue($this->options, 'name', $this->name);

        $svg = new Svg(static::$defaults);
        return $svg->getSvg($this->options);
    }
}
