<?php
namespace thoulah\fontawesome;

use yii\base\DynamicModel;
use yii\bootstrap4\Html;
use yii\helpers\ArrayHelper;

class Options {
	private $validGroupSizes = ['sm', 'md', 'lg'];
	private $validStyles = ['solid', 'regular', 'light', 'brands'];

	public $defaultAppend = false;
	public $defaultFill = 'currentColor';
	public $defaultGroupSize = 'md';
	public $defaultStyle = 'solid';
	public $fallbackIcon = '@vendor/fortawesome/font-awesome/svgs/solid/question-circle.svg';
	public $fontAwesomeFolder = '@vendor/fortawesome/font-awesome/svgs';
	public $prefix = 'svg-inline--fa';

	/*
	 *	Construct
	 */
	public function __construct() {
		return $this;
	}

	public function validate($options): ?string {
		$model = DynamicModel::validateData(
			[
				'name' => ArrayHelper::getValue($options, 'name'),
				'style' => ArrayHelper::getValue($options, 'style', $this->defaultStyle),
				'append' => ArrayHelper::getValue($options, 'append', $this->defaultAppend),
				'class' => ArrayHelper::getValue($options, 'class'),
				'height' => ArrayHelper::getValue($options, 'height'),
				'fill' => ArrayHelper::getValue($options, 'fill'),
				'fixedWidth' => ArrayHelper::getValue($options, 'fixedWidth'),
				'groupSize' => ArrayHelper::getValue($options, 'groupSize', $this->defaultGroupSize),
				'prefix' => ArrayHelper::getValue($options, 'prefix'),
				'title' => ArrayHelper::getValue($options, 'title'),
			],
			[
				[['name'], 'required', 'when' => function($options) { return is_array($options); }],
				[['style'], 'in', 'range' => $this->validStyles],
				[['append', 'fixedWidth'], 'boolean'],
				[['class', 'fill', 'prefix', 'title'], 'string'],
				[['height'], 'integer'],
				[['groupSize'], 'in', 'range' => $this->validGroupSizes],
			]
		);

		return $this->outputErrors($model);
	}

	private function outputErrors(DynamicModel $model): ?string {
		if ($model->hasErrors())
			return Html::errorSummary($model);
		return null;
	}
}
