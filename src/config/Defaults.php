<?php
namespace thoulah\fontawesome\config;

use yii\base\DynamicModel;
use yii\helpers\ArrayHelper;

/**
 * Sets default opions
 *
 * @return self default values
 */
class Defaults extends config
{
    /**
     * @var bool ActiveForm specific option. Sets fixed width icons.
     * Set to `false` to have variable width icons. Overrules `fixedWidth`
     */
    public $activeFormFixedWidth = true;

    /**
     * @var bool ActiveForm specific option. Whether to prepend or append the `input-group`
     */
    public $append = false;

    /**
     * @var string Bootstrap namespace to use – Currently the only supported option
     */
    public $bootstrap = 'bootstrap4';

    /**
     * @var string Backup icon in case requested icon cannot be found
     */
    public $fallbackIcon = '@vendor/fortawesome/font-awesome/svgs/solid/question-circle.svg';

    /**
     * @var string Color of the icon. Set to empty string to disable this attribute
     */
    public $fill = 'currentColor';

    /**
     * @var bool Set to `true` to have fixed width icons
     */
    public $fixedWidth = false;

    /**
     * @var string Path to your Font Awesome installation
     * Usable for Font Awesome Pro
     */
    public $fontAwesomeFolder = '@vendor/fortawesome/font-awesome/svgs';

    /**
     * @var string ActiveForm specific option. Set to `sm` for small or `lg` for large
     */
    public $groupSize = 'md';

    /**
     * @var string CSS class basename, requires custom CSS if changed
     */
    public $prefix = 'svg-inline--fa';

    /**
     * @var bool Whether or not to register the Font Awesome assets.
     */
    public $registerAssets = true;

    /**
     * @var string See
     * [Referencing Icons](https://fontawesome.com/how-to-use/on-the-web/referencing-icons/basic-use)
     * Usable for Font Awesome Pro
     */
    public $style = 'solid';

    /**
     * Creates a new Defaults object
     */
    public function __construct(array $defaults = [])
    {
        $allowedDefaults = array_intersect_key($defaults, get_class_vars(__CLASS__));

        parent::__construct($allowedDefaults);
    }

    /**
     * Validate the defaults
     * @return string|null Validation errors
     */
    public function validate(): ?string
    {
        $model = DynamicModel::validateData(
            ArrayHelper::toArray($this),
            [
                [['activeFormFixedWidth', 'append', 'fixedWidth', 'registerAssets'], 'boolean'],
                [['bootstrap'], 'in', 'range' => self::VALID_BOOTSTRAP],
                [['fill', 'fallbackIcon', 'fontAwesomeFolder', 'prefix'], 'string'],
                [['groupSize'], 'in', 'range' => self::VALID_GROUPSIZES],
                [['style'], 'in', 'range' => self::VALID_STYLES],
            ]
        );

        return $this->errorSummary($model);
    }
}
