<?php
/**
 * Configuration file for the "yii asset" console command.
 * Note that in the console environment, some path aliases like '@webroot' and '@web' may not exist.
 * Please define these missing path aliases.
 */
$basePath = __DIR__ . '/../web/assets';
$baseUrl = 'assets';
return [
    // Adjust command/callback for JavaScript files compressing:
    'jsCompressor' => 'java -jar tools/compiler.jar --js {from} --js_output_file {to}',
    // Adjust command/callback for CSS files compressing:
    'cssCompressor' => 'java -jar tools/yuicompressor.jar --type css {from} -o {to}',
    // The list of asset bundles to compress:
    'bundles' => [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
    ],
    // Asset bundle for compression output:
    'targets' => [
        'app\assets\AllAsset' => [
            'basePath' => $basePath,
            'baseUrl' => $baseUrl,
            'js' => 'all-{ts}.js',
            'css' => 'all-{ts}.css',
        ],
    ],
    // Asset manager configuration:
    'assetManager' => [
        'basePath' => $basePath,
        'baseUrl' => $baseUrl,
    ],
];