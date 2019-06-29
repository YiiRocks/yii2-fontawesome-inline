<?php

/**
 * @link https://fontawesome.mr42.me/
 * @license https://github.com/Thoulah/yii2-fontawesome-inline/blob/master/LICENSE
 */

namespace thoulah\fontawesome;

use thoulah\fontawesome\config\Defaults;
use yii\helpers\ArrayHelper;

/**
 * IconComponent provides an easy way to access Font Awesome icons throughout your project.
 * This allows you to override default settings once instead of per usage.
 *
 * Add `IconComponent` as component to your Yii config file:
 * ```php
 * 'components' => [
 *     'fontawesome' => [
 *         'class' => thoulah\fontawesome\IconComponent::class,
 * //      'fontAwesomeFolder' => '@npm/fontawesome-pro/svgs',
 * //      'style' => 'regular',
 *     ]
 * ]
 * ```
 *
 * Now you can globally insert an icon:
 * ```php
 * echo Yii::$app->fontawesome->name('at');
 * echo Yii::$app->fontawesome->name('github', 'brands')->fill->('#003865');
 * echo Yii::$app->fontawesome->name('font-awesome', 'brands')->class('yourClass');
 * ```
 *
 * @method name(string $name, ?string $style)
 * @method append(bool $append)
 * @method class(string $class)
 * @method fill(string $fill)
 * @method fixedWidth(bool $fixedWidth)
 * @method groupSize(string $groupSize)
 * @method height(int $height)
 * @method title(string $title)
 */
class IconComponent extends \yii\base\Component
{
    /**
     * @var array overrides for the default settings
     */
    public $config;

    /**
     * @var object default settings
     */
    public $defaults;

    /**
     * @var array icon options
     */
    private $icon = [];

    /**
     * {@inheritdoc}
     * @param array>|null $config configuration of the icon
     */
    public function __construct(array $config = [])
    {
        $this->defaults = new Defaults($config);
    }

    /**
     * Magic function, sets icon properties.
     * @param string $name name of the property
     * @param array $value property value
     */
    public function __call($name, $value): self
    {
        $this->icon[$name] = $value[0];
        return $this;
    }

    /**
     * Magic function, returns the SVG string.
     */
    public function __toString(): string
    {
        $svg = new Svg($this->defaults);
        $svg->getSvg($this->icon);
        $this->icon = [];
        return $svg;
    }

    /**
     * Returns the ActiveField inputTemplate.
     * @return string ActiveField addon with icon and proper code
     */
    public function activeFieldAddon(): string
    {
        $Html = __NAMESPACE__ . "\\{$this->defaults->bootstrap}\\Html";
        $groupSize = ArrayHelper::remove($this->icon, 'groupSize', $this->defaults->groupSize);

        $append = ArrayHelper::getValue($this->icon, 'append', $this->defaults->append);
        $icon = $Html::activeFieldAddon($groupSize, $append);
        return str_replace('{icon}', $this->activeFieldIcon(), $icon);
    }

    /**
     * Returns the ActiveField Icon.
     * @return string ActiveField icon with proper code
     */
    public function activeFieldIcon(): string
    {
        $Html = __NAMESPACE__ . "\\{$this->defaults->bootstrap}\\Html";
        if (!isset($this->icon['fixedWidth'])) {
            ArrayHelper::setValue($this->icon, 'fixedWidth', $this->defaults->activeFormFixedWidth);
        }

        $append = ArrayHelper::remove($this->icon, 'append', $this->defaults->append);
        $icon = $Html::activeFieldIcon($append);
        return str_replace('{icon}', $this, $icon);
    }

    /**
     * Sets the name and the style of the icon.
     * @param string $name name of the icon, or filename
     * @param string|null $style name of the icon
     * @return self values
     */
    public function name(string $name, string $style = null): self
    {
        $this->icon['name'] = $name;
        $this->icon['style'] = $style ?? $this->defaults->style;
        return $this;
    }
}
