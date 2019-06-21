<?php
/**
 *  @link https://thoulah.mr42.me/fontawesome
 *  @license https://github.com/Thoulah/yii2-fontawesome-inline/blob/master/LICENSE
 */

namespace thoulah\fontawesome;

use yii\base\DynamicModel;
use yii\helpers\ArrayHelper;

class Options {
	private $defaultOptions = [
		'activeFormFixedWidth',
		'append',
		'bootstrap',
		'fallbackIcon',
		'fill',
		'fixedWidth',
		'fontAwesomeFolder',
		'groupSize',
		'prefix',
		'registerAssets',
		'style',
	];
	private $validBootstrap = ['bootstrap4'];
	private $validGroupSizes = ['sm', 'md', 'lg'];
	private $validStyles = ['solid', 'regular', 'light', 'brands'];

	public $activeFormFixedWidth = true;
	public $append = false;
	public $bootstrap = 'bootstrap4';
	public $fallbackIcon = '@vendor/fortawesome/font-awesome/svgs/solid/question-circle.svg';
	public $fill = 'currentColor';
	public $fixedWidth = false;
	public $fontAwesomeFolder = '@vendor/fortawesome/font-awesome/svgs';
	public $groupSize = 'md';
	public $prefix = 'svg-inline--fa';
	public $registerAssets = true;
	public $style = 'solid';

	/*
	 *	Construct
	 */
	public function __construct() {
		return $this;
	}

	public function validateDefaults($options): ?string {
		foreach ($this->defaultOptions as $option) {
			$values[$option] = ArrayHelper::getValue($options, $option, $this->$option);
		}

		$model = DynamicModel::validateData(
			$values,
			[
				[$this->defaultOptions, 'required'],
				[['activeFormFixedWidth', 'append', 'fixedWidth', 'registerAssets'], 'boolean'],
				[['fill', 'fallbackIcon', 'fontAwesomeFolder', 'prefix'], 'string'],
				[['bootstrap'], 'in', 'range' => $this->validBootstrap],
				[['groupSize'], 'in', 'range' => $this->validGroupSizes],
				[['style'], 'in', 'range' => $this->validStyles],
			]
		);

		return $this->outputErrors($model);
	}

	public function validateOptions($options): ?string {
		$model = DynamicModel::validateData(
			[
				'name' => ArrayHelper::getValue($options, 'name'),
				'style' => ArrayHelper::getValue($options, 'style', $this->style),
				'append' => ArrayHelper::getValue($options, 'append', $this->append),
				'class' => ArrayHelper::getValue($options, 'class'),
				'height' => ArrayHelper::getValue($options, 'height'),
				'fill' => ArrayHelper::getValue($options, 'fill'),
				'fixedWidth' => ArrayHelper::getValue($options, 'fixedWidth', $this->fixedWidth),
				'groupSize' => ArrayHelper::getValue($options, 'groupSize', $this->groupSize),
				'prefix' => ArrayHelper::getValue($options, 'prefix'),
				'title' => ArrayHelper::getValue($options, 'title'),
			],
			[
				[['name'], 'required'],
				[['style'], 'in', 'range' => $this->validStyles],
				[['append', 'fixedWidth'], 'boolean'],
				[['class', 'fill', 'prefix', 'title'], 'string'],
				[['height'], 'integer', 'min' => 1],
				[['groupSize'], 'in', 'range' => $this->validGroupSizes],
			]
		);

		return $this->outputErrors($model);
	}

	private function outputErrors(DynamicModel $model): ?string {
		if ($model->hasErrors()) {
			$Html = __NAMESPACE__ . "\\{$this->bootstrap}\\Html";
			return $Html::errorSummary($model);
		}

		return null;
	}
}
