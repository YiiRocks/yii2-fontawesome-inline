<?php

/**
 * @link https://fontawesome.mr42.me/
 * @license https://github.com/Thoulah/yii2-fontawesome-inline/blob/master/LICENSE
 */

namespace thoulah\fontawesome\bootstrap4;

use thoulah\fontawesome\Icon;
use thoulah\fontawesome\IconComponent;
use Yii;
use yii\helpers\ArrayHelper;

/**
*
* It is possible to use the icons in forms as described on the Bootstrap [Input group](https://getbootstrap.com/docs/4.3/components/input-group/) page.
*
* ## Automatic
*
* ```php
* use thoulah\fontawesome\bootstrap4\ActiveForm;
*
* $form = ActiveForm::begin();
*
* echo $form->field($model, 'field1', [
*     'icon' => 'user',
* ]);
*
* echo $form->field($model, 'field2', [
*     'icon' => [
*         'name' => 'github',
*         'style' => 'brands',
*     ],
* ]);
*
* echo $form->field($model, 'field3', [
*     'icon' => [
*         'name' => 'github',
*         'style' => 'brands',
*         'append' => true,
*     ],
* ]);
*
* ActiveForm::end();
* ```
*
* ## Manual
*
* For `$icon` you can use any earlier described usage method.
*
* ```php
* $form = ActiveForm::begin();
*
* echo $form->field($model, 'field', [
*     'inputTemplate' => $icon->activeFieldAddon('user'),
* ]);
*
* ActiveForm::end();
* ```
*
* ```php
* $form = ActiveForm::begin();
*
* echo $form->field($model, 'field', [
*     'inputTemplate' => '<div id="yourClass" class="float-right">YourText</div>'.$icon->activeFieldAddon('font-awesome', ['style' => 'brands']),
* ]);
*
* ActiveForm::end();
* ```
*
* ```php
* $form = ActiveForm::begin();
*
* echo $form->field($model, 'field', [
*     'inputTemplate' => '<div class="input-group">YourText'.$icon->activeFieldIcon('font-awesome', ['style' => 'brands']).'{input}</div>',
* ]);
*
* ActiveForm::end();
* ```
*
* Please see [[\thoulah\fontawesome\config\Options]] for more information.
 */
class ActiveField extends \yii\bootstrap4\ActiveField
{
    /**
     * @var array per-icon settings
     */
    public $icon;

    /**
     * Rendering our field
     */
    public function render($content = null)
    {
        if (!empty($this->icon)) {
            if (is_string($this->icon)) {
                $this->icon = ['name' => $this->icon];
            }

            $groupSize = ArrayHelper::remove($this->icon, 'groupSize');
            $append = ArrayHelper::getValue($this->icon, 'append');

            $fieldAddon = Html::activeFieldAddon($groupSize, $append);
            $fieldIcon = Html::activeFieldIcon($append);
            $inputTemplate = str_replace('{icon}', $fieldIcon, $fieldAddon);
            $this->inputTemplate = str_replace('{icon}', $this->callComponentOrClass(), $inputTemplate);
        }

        return parent::render($content);
    }

    /**
     * Tries to find component id. If that cannot be found we fall be to running as class.
     */
    private function callComponentOrClass(): string
    {
        foreach (Yii::$app->components as $key => $value) {
            if (!isset($value['class'])) {
                continue;
            } elseif ($value['class'] === IconComponent::class) {
                return $this->runAsComponent(Yii::$app->$key);
            }
        }

        return $this->runAsClass();
    }

    /**
     * We run as class.
     */
    private function runAsClass(): string
    {
        $icon = new Icon();
        $iconName = ArrayHelper::remove($this->icon, 'name');

        if (!isset($this->icon['fixedWidth'])) {
            $this->icon['fixedWidth'] = $icon->defaults->activeFormFixedWidth;
        }

        return $icon->show($iconName, $this->icon);
    }

    /**
     * We run as component.
     */
    private function runAsComponent(IconComponent $icon): string
    {
        $iconName = ArrayHelper::remove($this->icon, 'name');
        $iconStyle = ArrayHelper::remove($this->icon, 'style');
        $icon->name($iconName, $iconStyle);

        $fixedWidth = ArrayHelper::remove($this->icon, 'fixedWidth', $icon->defaults->activeFormFixedWidth);
        $icon->fixedWidth($fixedWidth);

        foreach (['append', 'class', 'fill', 'height', 'title'] as $property) {
            $prop = ArrayHelper::remove($this->icon, $property);
            if ($prop !== null) {
                $icon->$property($prop);
            }
        }

        return $icon;
    }
}
