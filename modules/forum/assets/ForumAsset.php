<?php
namespace app\modules\forum\assets;

use Yii;
use app\components\AssetBundle;

class ForumAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/forum/assets/web';
    public $css = [
        'css/forum.css',
    ];
    public $depends = [
        'app\assets\AppAsset',
    ];
}
