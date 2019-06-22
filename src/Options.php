<?php
/**
 *  @link https://fontawesome.mr42.me/
 *  @license https://github.com/Thoulah/yii2-fontawesome-inline/blob/master/LICENSE
 */

namespace thoulah\fontawesome;

use yii\base\DynamicModel;
use yii\helpers\ArrayHelper;

/**
 * ## Icon Options.
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
 * ## ActiveForm Specific Options
 *
 * *   `append` bool. Whether to prepend or append the `input-group`
 *
 * *   `fixedWidth` bool. Set to `false` to have variable width icons
 *
 * *   `groupSize` string. Set to `sm` for small or `lg` for large
 */
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
	private $iconOptions = [
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
	public function __construct(array $options = null) {
		if ($options !== null) {
			foreach ($options as $key => $value) {
				$this->$key = $value;
			}
		}

		return $this;
	}

	public function validateDefaults(): ?string {
		$model = DynamicModel::validateData(
			ArrayHelper::toArray($this),
			[
				[$this->defaultOptions, 'required'],
				[['activeFormFixedWidth', 'append', 'fixedWidth', 'registerAssets'], 'boolean'],
				[['bootstrap'], 'in', 'range' => $this->validBootstrap],
				[['fill', 'fallbackIcon', 'fontAwesomeFolder', 'prefix'], 'string'],
				[['groupSize'], 'in', 'range' => $this->validGroupSizes],
				[['style'], 'in', 'range' => $this->validStyles],
			]
		);

		return $this->outputErrors($model);
	}

	public function validateOptions(?array $options): ?string {
		$model = DynamicModel::validateData(
			ArrayHelper::merge(array_fill_keys($this->iconOptions, null), $options ?? []),
			[
				[['name'], 'required'],
				[['append', 'fixedWidth'], 'boolean'],
				[['class', 'fill', 'prefix', 'title'], 'string'],
				[['height'], 'integer', 'min' => 1],
				[['groupSize'], 'in', 'range' => $this->validGroupSizes],
				[['style'], 'in', 'range' => $this->validStyles],
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
