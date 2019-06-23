<?php
/**
 * @link https://fontawesome.mr42.me/
 * @license https://github.com/Thoulah/yii2-fontawesome-inline/blob/master/LICENSE
 */

namespace thoulah\fontawesome\config;

use yii\base\DynamicModel;
use yii\helpers\ArrayHelper;

/**
 * # Configuration.
 *
 * ## Global Options
 *
 * *   `bootstrap` string `bootstrap4`. Bootstrap namespace to use – Currently the only supported.
 * 	option
 *
 *    `fill` string `currentColor`. Color of the icon. Set to empty string to disable this attribute
 *
 * *  `fixedWidth` bool `false`. Set to `true` to have fixed width icons
 *
 * *  `style` string `solid`. See
 * 	[Referencing Icons](https://fontawesome.com/how-to-use/on-the-web/referencing-icons/basic-use)
 * 	Usable for Font Awesome Pro
 *
 * *  `fallbackIcon` string `@vendor/fortawesome/font-awesome/svgs/solid/question-circle.svg`. Backup
 * 	icon in case requested icon cannot be found
 *
 * *  `fontAwesomeFolder` string `@vendor/fortawesome/font-awesome/svgs`. Path to your Font Awesome
 * 	installation
 * 	Usable for Font Awesome Pro
 *
 * *  `prefix` string `svg-inline--fa`. CSS class basename, requires custom CSS if changed
 *
 * *  `registerAssets` bool `true`. Whether or not to register the Font Awesome assets.
 *
 * ### ActiveForm Specific Global Options
 *
 * *  `ActiveFormFixedWidth` bool `true`. Set to `false` to have variable width icons. Overrules
 * 	`fixedWidth`
 *
 * *  `append` bool `false`. Whether to prepend or append the `input-group`
 *
 * *  `groupSize` string `md`. Set to `sm` for small or `lg` for large
 *
 * @return array Defaults default values
 */
class Defaults extends config {
	private $defaults = [
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

	/*
	 * @var bool ActiveForm specific options. Sets fixed width icons.
	 * Set to `false` to have variable width icons. Overrules `fixedWidth`
	 */
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

	public function validate(): ?string {
		$model = DynamicModel::validateData(
			ArrayHelper::toArray($this),
			[
				[$this->defaults, 'required'],
				[['activeFormFixedWidth', 'append', 'fixedWidth', 'registerAssets'], 'boolean'],
				[['bootstrap'], 'in', 'range' => $this->validBootstrap],
				[['fill', 'fallbackIcon', 'fontAwesomeFolder', 'prefix'], 'string'],
				[['groupSize'], 'in', 'range' => $this->validGroupSizes],
				[['style'], 'in', 'range' => $this->validStyles],
			]
		);

		return $this->outputErrors($model);
	}
}
