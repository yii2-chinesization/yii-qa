<?php

namespace app\modules\user\assets;

use app\components\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class UserAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/user/assets/web';
    public $css = [
        'css/user.css',
    ];
    public $js = [
        //'js/user.js',
    ];
    public $depends = [
        'app\assets\AppAsset',
    ];
}
