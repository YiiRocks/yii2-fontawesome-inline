<?php
namespace Thoulah\FontAwesomeInline;

use yii\web\AssetBundle;

/**
 * Asset bundle for the Font Awesome css files.
 */
class FontAwesomeAsset extends AssetBundle
{
    public $sourcePath = '@bower/fontawesome/css';
    public $css = [
        'svg-with-js'.(YII_DEBUG ? '' : '.min').'.css'
    ];
}
