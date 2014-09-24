<?php

namespace app\assets;

use app\components\AssetBundle;

class ArtTemplateAsset extends AssetBundle
{
    public $sourcePath = '@npm/art-template';
    public $js = [
        'dist/template.js',
    ];
}