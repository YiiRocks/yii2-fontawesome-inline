<?php
/**
 *  @link https://fontawesome.mr42.me/
 *  @license https://github.com/Thoulah/yii2-fontawesome-inline/blob/master/LICENSE
 */

namespace thoulah\fontawesome;

use yii\web\AssetBundle;

/**
 * Asset bundle for the Font Awesome CSS file.
 */
class FontAwesomeAsset extends AssetBundle {
	public $sourcePath = '@vendor/fortawesome/font-awesome/css';
	public $css = [
		'svg-with-js' . (YII_DEBUG ? '' : '.min') . '.css',
	];
}
