<?php

/**
 * @link https://fontawesome.mr42.me/
 * @license https://github.com/Thoulah/yii2-fontawesome-inline/blob/master/LICENSE
 */

namespace thoulah\fontawesome\config;

use yii\base\DynamicModel;
use yii\helpers\ArrayHelper;

/**
 * Icon Options.
 *
 * *   `name` string. Name of the icon, picked from [Icons](https://fontawesome.com/icons).
 *
 * *   `style` string. Style of the icon, must match `name`
 *
 * *   `class` string. Additional custom classes.
 *
 * *   `fill` string. Color of the icon
 *
 * *   `fixedWidth` bool. Set to `true` to have a fixed width icon
 *
 * *   `height` int. The height of the icon. This will override height and width classes.
 *
 * *   `prefix` string. CSS class name, requires custom CSS if changed
 *
 * *   `title` string. Sets a title to the SVG output.
 *
 * ActiveForm Specific Options
 *
 * *   `append` bool. Whether to prepend or append the `input-group`
 *
 * *   `fixedWidth` bool. Set to `false` to have variable width icons
 *
 * *   `groupSize` string. Set to `sm` for small or `lg` for large
 */
class Options extends config
{
    /**
     * @var array Valid options
     */
    private $_iconOptions = [
        'name',
        'style',
        'append',
        'class',
        'height',
        'fill',
        'fixedWidth',
        'groupSize',
        'prefix',
        'title',
    ];

    /**
     * Validates the options
     * @param array|null $options Options
     * @return string|null Validation errors
     */
    public function validate(?array $options): ?string
    {
        $model = DynamicModel::validateData(
            ArrayHelper::merge(array_fill_keys($this->_iconOptions, null), $options ?? []),
            [
                [['name'], 'required'],
                [['append', 'fixedWidth'], 'boolean'],
                [['class', 'fill', 'prefix', 'title'], 'string'],
                [['height'], 'integer', 'min' => 1],
                [['groupSize'], 'in', 'range' => $this->validGroupSizes],
                [['style'], 'in', 'range' => $this->validStyles],
            ]
        );

        return $this->errorSummary($model);
    }
}
