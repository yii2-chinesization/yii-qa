<?php
namespace app\assets;

use Yii;
use app\components\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/global.css',
        'css/ui.css'
    ];
    public $js = [
        'js/global.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'app\assets\ArtTemplateAsset'
    ];
}
