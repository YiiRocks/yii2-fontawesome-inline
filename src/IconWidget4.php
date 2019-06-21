<?php
/**
 *  @link https://thoulah.mr42.me/fontawesome
 *  @license https://github.com/Thoulah/yii2-fontawesome-inline/blob/master/LICENSE
 */

namespace thoulah\fontawesome;

use yii\helpers\ArrayHelper;

/**
 * IconComponent provides an easy way to access Font Awesome icons using Widget.
 *
 * ```php
 * use thoulah\fontawesome\IconWidget4 as IconWidget;
 * echo IconWidget::widget(['name' => 'at']);
 *
 * echo IconWidget::widget([
 *	'name' => 'github',
 *	'options' => [
 *		'style' => 'brands',
 *		'fill' => '#003865'
 * 	]
 * ]);
 *
 * echo IconWidget::widget([
 * 	'name' => 'font-awesome',
 * 	'options' => [
 * 		'class' => 'yourClass',
 * 		'style' => 'brands'
 * 	],
 * ]);
 * ```
 */
class IconWidget4 extends \yii\bootstrap4\Widget {
	public static $defaults = [];
	public $name;
	public $options = [];

	/**
	 * {@inheritdoc}
	 */
	public function run(): string {
		ArrayHelper::setValue($this->options, 'name', $this->name);

		$svg = new Svg(static::$defaults);
		return $svg->getString($this->options);
	}
}
