<?php
namespace Thoulah\FontAwesomeInline\bootstrap4;

class ActiveForm extends \yii\bootstrap4\ActiveForm {
	public $fieldClass = 'Thoulah\FontAwesomeInline\bootstrap4\ActiveField';

	/**
	 * {@inheritdoc}
	 * @return \yii\widgets\ActiveField
	 */
	public function field($model, $attribute, $options = []) {
		return parent::field($model, $attribute, $options);
	}
}
