<?php
namespace thoulah\fontawesome;

use yii\web\AssetBundle;

/**
 * Asset bundle for the Font Awesome CSS file.
 */
class FontAwesomeAsset extends AssetBundle
{
    /**
     * @var array CSS files to load
     */
    public $css = [
        'svg-with-js.min.css'
    ];

    /**
     * @var string Path to Font Awesome CSS folder
     */
    public $sourcePath = '@vendor/fortawesome/font-awesome/css';
}
