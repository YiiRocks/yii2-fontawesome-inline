<?php
namespace thoulah\fontawesome;

use thoulah\fontawesome\config\Defaults;
use thoulah\fontawesome\helpers\Image;
use yii\helpers\ArrayHelper;

/**
 * Provides a quick and easy way to access icons.
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
    /** @var Defaults default settings */
    public $defaults;

    /**
     * Creates a new Icon object
     *
     * @param array|null $config configuration of the icon
     */
    public function __construct(array $config = [])
    {
        $this->defaults = new Defaults($config);
    }

    /**
     * Returns the ActiveField inputTemplate.
     *
     * @param string $name Name of the icon
     * @param array|null $options Options for the field and the icon
     * @return string ActiveField addon with icon and proper code
     */
    public function activeFieldAddon(string $name, array $options = []): string
    {
        $html = __NAMESPACE__ . "\\{$this->defaults->bootstrap}\\Html";
        $groupSize = ArrayHelper::remove($options, 'groupSize', $this->defaults->groupSize);

        $append = ArrayHelper::getValue($options, 'append', $this->defaults->append);
        $icon = $html::activeFieldAddon($groupSize, $append);
        return str_replace('{icon}', $this->activeFieldIcon($name, $options), $icon);
    }

    /**
     * Returns the ActiveField Icon.
     *
     * @param string $name Name of the icon
     * @param array|null $options Options for the field and the icon
     * @return string ActiveField icon with proper code
     */
    public function activeFieldIcon(string $name, array $options = []): string
    {
        $html = __NAMESPACE__ . "\\{$this->defaults->bootstrap}\\Html";

        $append = ArrayHelper::remove($options, 'append', $this->defaults->append);
        $icon = $html::activeFieldIcon($append);
        return str_replace('{icon}', $this->show($name, $options), $icon);
    }

    /**
     * Outputs the SVG string.
     *
     * @param string $name Name of the icon, or filename
     * @param array|null $options Options for the icon
     * @return string The icon
     */
    public function show(string $name, array $options = []): string
    {
        ArrayHelper::setValue($options, 'name', $name);

        $image = new Image($this->defaults);
        return $image->get($options);
    }
}
