<?php

namespace app\assets;

use app\components\AssetBundle;

class AdminLteAsset extends AssetBundle
{
    public $sourcePath = '@bower/adminlte';
    public $css = [
        'css/AdminLTE.css',
    ];
    public $js = [
        'js/admin.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\bootstrapAsset',
        'yii\bootstrap\bootstrapPluginAsset'
    ];
}