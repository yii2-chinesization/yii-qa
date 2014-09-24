<?php

namespace app\assets;

use app\components\AssetBundle;

class BootstrapGrowlAsset extends AssetBundle
{
    public $sourcePath = '@bower/bootstrap-growl';
    public $js = [
        'jquery.bootstrap-growl.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}