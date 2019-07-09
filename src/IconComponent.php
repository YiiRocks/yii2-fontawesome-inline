<?php
namespace thoulah\fontawesome;

use thoulah\fontawesome\config\Defaults;
use thoulah\fontawesome\helpers\Svg;
use yii\helpers\ArrayHelper;

/**
 * IconComponent provides an easy way to access Font Awesome icons throughout your project.
 * This allows you to override default settings once instead of per usage or file.
 *
 * Add IconComponent as component to your Yii config file:
 *
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
 *
 * ```php
 * echo Yii::$app->fontawesome->name('at');
 * echo Yii::$app->fontawesome->name('github', 'brands')->fill->('#003865');
 * echo Yii::$app->fontawesome->name('font-awesome', 'brands')->class('yourClass');
 * ```
 *
 * @method self append() append(bool $append) Whether to prepend or append the `input-group`
 * @method self class() class(string $class) Additional custom classes
 * @method self css() css(array $css) Custom CSS style
 * @method self fill() fill(string $fill) Color of the icon
 * @method self fixedWidth() fixedWidth(bool $fixedWidth) Whether or not to have fixed width icons
 * @method self groupSize() groupSize(string $groupSize) Set to `sm` for small or `lg` for large
 * @method self height() height(int $height) The height of the icon. This will override height and width classes
 * @method self id() id(string $id) ID for the SVG tag
 * @method self title() title(string $title) Sets a title to the SVG output
 * @method self width() width(int $width) The width of the icon. This will override height and width classes
 */
class IconComponent extends \yii\base\Component
{
    /** @var Defaults default settings */
    public $defaults;

    /** @var array icon options */
    private $icon = [];

    /**
     * Creates a new IconComponent object
     *
     * @param array|null $overrides Overrides of the default settings
     */
    public function __construct(array $overrides = [])
    {
        $this->defaults = new Defaults($overrides);
    }

    /**
     * Magic function, sets icon properties.
     *
     * Supported options are listed in @method, but
     * [no support](https://github.com/yiisoft/yii2-apidoc/issues/136) in the docs yet.
     *
     * @param string $name property name
     * @param array $value property value
     * @return self updated object
     */
    public function __call($name, $value): self
    {
        $this->icon[$name] = $value[0];
        return $this;
    }

    /**
     * Magic function, returns the SVG string.
     *
     * @return string SVG data
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
     *
     * @param string $name name of the icon, or filename
     * @param string|null $style style of the icon
     * @return string ActiveField addon with icon and proper code
     */
    public function activeFieldAddon(string $name, string $style = null): string
    {
        $html = __NAMESPACE__ . "\\{$this->defaults->bootstrap}\\Html";
        $groupSize = ArrayHelper::remove($this->icon, 'groupSize', $this->defaults->groupSize);

        $append = ArrayHelper::getValue($this->icon, 'append', $this->defaults->append);
        $icon = $html::activeFieldAddon($groupSize, $append);
        return str_replace('{icon}', $this->activeFieldIcon($name, $style), $icon);
    }

    /**
     * Returns the ActiveField Icon.
     *
     * @param string $name name of the icon, or filename
     * @param string|null $style style of the icon
     * @return string ActiveField icon with proper code
     */
    public function activeFieldIcon(string $name, string $style = null): string
    {
        $this->name($name, $style);
        $html = __NAMESPACE__ . "\\{$this->defaults->bootstrap}\\Html";
        if (!isset($this->icon['fixedWidth'])) {
            ArrayHelper::setValue($this->icon, 'fixedWidth', $this->defaults->activeFormFixedWidth);
        }

        $append = ArrayHelper::remove($this->icon, 'append', $this->defaults->append);
        $icon = $html::activeFieldIcon($append);
        return str_replace('{icon}', $this, $icon);
    }

    /**
     * Sets the name and style of the icon.
     *
     * @param string $name name of the icon, or filename
     * @param string|null $style style of the icon
     * @return self component object
     */
    public function name(string $name, string $style = null): self
    {
        $this->icon['name'] = $name;
        $this->icon['style'] = $style ?? $this->defaults->style;
        return $this;
    }
}
