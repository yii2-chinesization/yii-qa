<?php

namespace app\modules\admin\assets;

use app\components\AssetBundle;

class AdminAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/admin/assets/web';
    public $css = [
        'css/AdminLTE.css',
        'css/admin.css',
    ];
    public $js = [
        'js/AdminLTE.js',
        'js/admin.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\bootstrapAsset',
        'yii\bootstrap\bootstrapPluginAsset'
    ];
}
