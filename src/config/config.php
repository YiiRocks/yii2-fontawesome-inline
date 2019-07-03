<?php
namespace thoulah\fontawesome\config;

use yii\base\DynamicModel;
use yii\helpers\Html;

/**
 * Sets default options
 *
 * @return self Option values
 */
class config
{
    /**
     * @var array valid options of `groupSize`
     */
    protected $validGroupSizes = ['sm', 'md', 'lg'];

    /**
     * @var array valid options of `style`
     */
    protected $validStyles = ['solid', 'regular', 'light', 'brands'];

    /**
     * Creates a new config object
     * @param array $options Options
     * @return self $this default values
     */
    public function __construct(array $options)
    {
        foreach ($options as $key => $value) {
            $this->$key = $value;
        }

        return $this;
    }

    /**
     * Checks if validation returned errors and returns the errors
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
