<?php

/**
 * @link https://fontawesome.mr42.me/
 * @license https://github.com/Thoulah/yii2-fontawesome-inline/blob/master/LICENSE
 */

namespace thoulah\fontawesome\config;

use yii\base\DynamicModel;
use yii\helpers\Html;

class config
{
    protected $validBootstrap = ['bootstrap4'];
    protected $validGroupSizes = ['sm', 'md', 'lg'];
    protected $validStyles = ['solid', 'regular', 'light', 'brands'];

    /*
     *	Construct
     */
    public function __construct(array $options = null)
    {
        if ($options !== null) {
            foreach ($options as $key => $value) {
                $this->$key = $value;
            }
        }

        return $this;
    }

    protected function outputErrors(DynamicModel $model): ?string
    {
        return ($model->hasErrors())
            ? Html::errorSummary($model)
            : null;
    }
}
