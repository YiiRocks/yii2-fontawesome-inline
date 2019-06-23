<?php

/**
 * @link https://fontawesome.mr42.me/
 * @license https://github.com/Thoulah/yii2-fontawesome-inline/blob/master/LICENSE
 */

namespace thoulah\fontawesome;

use yii\web\AssetBundle;

/**
 * Asset bundle for the Font Awesome CSS file.
 */
class FontAwesomeAsset extends AssetBundle
{
    /**
     * @var string Path to Font Awesome CSS folder
     */
    public $sourcePath = '@vendor/fortawesome/font-awesome/css';

    /**
     * @var array CSS files to load
     */
    public $css = [
        'svg-with-js' . (YII_DEBUG ? '' : '.min') . '.css',
    ];
}
