<?php

namespace app\modules\admin\assets;

use app\components\AssetBundle;

class AdminAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/admin/assets/web';
    public $css = [
        'css/admin.css',
    ];
    public $js = [
        'js/admin.js'
    ];
    public $depends = [
        'app\assets\AdminLteAsset'
    ];
}
