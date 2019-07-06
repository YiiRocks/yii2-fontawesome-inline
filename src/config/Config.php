<?php
namespace thoulah\fontawesome\config;

use yii\base\DynamicModel;
use yii\helpers\Html;

/**
 * Sets default options
 *
 * @return self Option values
 */
class Config extends \yii\base\BaseObject
{

    /**
     * @var array supported bootstrap versions
     */
    protected const VALID_BOOTSTRAP = ['bootstrap4'];

    /**
     * @var array valid options of `groupSize`
     */
    protected const VALID_GROUPSIZES = ['sm', 'md', 'lg'];

    /**
     * @var array valid options of `style`
     */
    protected const VALID_STYLES = ['solid', 'regular', 'light', 'brands'];

    /**
     * Checks if validation returned errors and returns the errors
     *
     * @param DynamicModel $model Validation model
     * @return string|null Validation errors
     */
    protected function errorSummary(DynamicModel $model): ?string
    {
        return ($model->hasErrors())
            ? Html::errorSummary($model)
            : null;
    }
}
