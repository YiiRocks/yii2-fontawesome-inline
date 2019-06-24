<?php

/**
 * @link https://fontawesome.mr42.me/
 * @license https://github.com/Thoulah/yii2-fontawesome-inline/blob/master/LICENSE
 */

namespace thoulah\fontawesome;

use thoulah\fontawesome\config\Defaults;
use yii\helpers\ArrayHelper;

/**
* Provides an easy way to access icons.
*
* ```php
* $icon = new \thoulah\fontawesome\Icon();
* echo $icon->show('at');
* echo $icon->show('github', ['style' => 'brands', 'fill' => '#003865']);
* echo $icon->show('font-awesome', ['class' => 'yourClass', 'style' => 'brands']);
* ```
 */
class Icon
{
    /**
     * @var Defaults default settings
     */
    public $defaults;

    /**
     * Construct.
     */
    public function __construct()
    {
        $this->defaults = new Defaults();
    }

    /**
     * Outputs the SVG string.
     * @param string $name Name of the icon
     * @param array|null $options [[\thoulah\fontawesome\config\Options]] for the icon
     * @return string The icon
     */
    public function show(string $name, array $options = []): string
    {
        ArrayHelper::setValue($options, 'name', $name);

        $svg = new Svg($this->defaults);
        return $svg->getSvg($options);
    }

    /**
     * Returns the ActiveField inputTemplate.
     * @param string $name Name of the icon
     * @param array|null $options [[\thoulah\fontawesome\config\Options]] for the field and the icon
     * @return string ActiveField addon with icon and proper code
     */
    public function activeFieldAddon(string $name, array $options = []): string
    {
        $Html = "thoulah\\fontawesome\\{$this->defaults->bootstrap}\\Html";
        $groupSize = ArrayHelper::remove($options, 'groupSize', $this->defaults->groupSize);

        $append = ArrayHelper::getValue($options, 'append', $this->defaults->append);
        $icon = $Html::activeFieldAddon($groupSize, $append);
        return str_replace('{icon}', $this->activeFieldIcon($name, $options), $icon);
    }

    /**
     * Returns the ActiveField Icon.
     * @param string $name Name of the icon
     * @param array|null $options [[\thoulah\fontawesome\config\Options]] for the field and the icon
     * @return string ActiveField icon with proper code
     */
    public function activeFieldIcon(string $name, array $options = []): string
    {
        $Html = "thoulah\\fontawesome\\{$this->defaults->bootstrap}\\Html";

        $append = ArrayHelper::remove($options, 'append', $this->defaults->append);
        $icon = $Html::activeFieldIcon($append);
        return str_replace('{icon}', $this->show($name, $options), $icon);
    }
}
