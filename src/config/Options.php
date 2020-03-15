<?php

namespace thoulah\fontawesome\config;

use yii\base\DynamicModel;
use yii\helpers\ArrayHelper;

/**
 * Icon Options.
 *
 * @return self Option values
 */
class Options extends BaseConfig
{
    /** @var bool Whether or not to add calculated classes to custom files */
    public $addClass = false;

    /** @var bool ActiveForm specific option. Whether to prepend or append the `input-group`
     * This will change both tag order and applied class. */
    public $append = false;

    /** @var string Additional custom classes */
    public $class;

    /** @var array Additional CSS attributes */
    public $css;

    /** @var string Color of the icon */
    public $fill;

    /** @var bool Whether or not to have fixed width icons */
    public $fixedWidth;

    /**
     * @var string ActiveForm specific option. Set to `sm` for small or `lg` for large
     * Defaults to `md` or medium.
     * */
    public $groupSize;

    /** @var int The height of the icon. This will dismiss the automatic height
     * and width classes. If `height` is given without `width`, the latter
     * will be calculated from the SVG size. */
    public $height;

    /** @var string Id for the SVG tag */
    public $id;

    /**
     * @var string Name of the icon
     * @see https://fontawesome.com/icons
     */
    public $name;

    /** @var string CSS class name, requires custom CSS if changed */
    public $prefix;

    /**
     * @var string Style of the icon, must match `name`
     * @see https://fontawesome.com/icons
     */
    public $style;

    /** @var string Sets a title to the SVG output */
    public $title;

    /** @var int The width of the icon. This will dismiss the automatic height
     * and width classes. If `height` is given without `width`, the latter
     * will be calculated from the SVG size. */
    public $width;

    /**
     * Creates a new Options object.
     *
     * @param array $options Options
     */
    public function __construct(array $options = [])
    {
        $allowedOptions = array_intersect_key($options, get_class_vars(__CLASS__));
        parent::__construct($allowedOptions);
    }

    /**
     * Validates the options.
     *
     * @param array|null $options Options
     *
     * @return string|null Validation errors
     */
    public function validate(): ?string
    {
        $options = ArrayHelper::toArray($this);

        $model = DynamicModel::validateData(
            ArrayHelper::merge(get_class_vars(__CLASS__), $options),
            [
                [['name'], 'required'],
                [['append', 'fixedWidth'], 'boolean'],
                [['class', 'fill', 'id', 'name', 'prefix', 'title'], 'string'],
                [['height', 'width'], 'integer', 'min' => 1],
                [['groupSize'], 'in', 'range' => self::VALID_GROUPSIZES],
                [['style'], 'in', 'range' => self::VALID_STYLES],
            ]
        );

        return $this->errorSummary($model);
    }
}
