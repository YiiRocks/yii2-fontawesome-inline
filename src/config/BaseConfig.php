<?php
namespace thoulah\fontawesome\config;

use yii\base\DynamicModel;
use yii\helpers\Html;

/**
 * Base for configuration, meant to be extended
 */
class BaseConfig extends \yii\base\BaseObject
{
    /** @var array supported bootstrap versions */
    protected const VALID_BOOTSTRAP = ['bootstrap4'];

    /** @var array valid options of `groupSize` */
    protected const VALID_GROUPSIZES = ['sm', 'md', 'lg'];

    /** @var array valid options of `style` */
    protected const VALID_STYLES = ['solid', 'regular', 'light', 'brands'];

    /**
     * Removes an item from the object and returns the value. If the key does not
     * exist in the object, the default value will be returned instead.
     *
     * @param string $key Key name of the object element
     * @param mixed $default The default value to be returned if the specified key does not exist
     */
    public function removeValue(string $key, $default = null)
    {
        if (isset($this->$key)) {
            $value = $this->$key;
            unset($this->$key);
            return $value;
        }
        return $default;
    }

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
