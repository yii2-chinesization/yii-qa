<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$config = [
    'id' => 'basic',
    'name' => 'Yii',
    'basePath' => dirname(__DIR__),
    'language' => 'zh-CN',
    'bootstrap' => ['log'],
    'extensions' => require(__DIR__ . '/../vendor/yiisoft/extensions.php'),
    'modules' => require(__DIR__ . '/modules.php'),
    'components' => [
        'request' => [
            'cookieValidationKey' => 'callmez',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'class' => 'app\modules\user\components\User',
            'identityClass' => 'app\modules\user\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mail' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['trace', 'error', 'warning'],
                ],
            ],
        ],
        'config' => [
            'class' => 'app\components\Config',
            'loadModel' => 'app\models\Config'
        ],
        'urlManager' => array(
            'showScriptName' => false,
            'enablePrettyUrl' => true,
            'rules' => require(__DIR__ . '/rewrite.php')
        ),
        'authManager' => [
            'class' => 'app\components\DbAuthManager',
        ],
//        'authClientCollection' => [
//            'class' => 'yii\authclient\Collection',
//            'clients' => [
//                'weibo' => [
//                    'class' => 'app\modules\user\components\authclient\clients\WeiBo',
//                    'clientId' => 'xxx',
//                    'clientSecret' => 'xxx',
//                ],
//                'qq' => [
//                    'class' => 'app\modules\user\components\authclient\clients\QQ',
//                    'clientId' => 'xxx',
//                    'clientSecret' => 'xxx',
//                ],
//            ],
//        ],
        'storageCollection' => [
            'class' => 'yii\storage\Collection',
//            'defaultStorage' => 'qiniu',
            'bin' => [
                'qiniu' => [
                    'class' => 'yii\storage\bin\QiniuStorage',
                    'bucket' => 'records',
                    'accessKey' => 'xxx',
                    'secretKey' => 'xxx'
                ]
            ]
        ],
        'db' => $db,
        'wechat' => [
            'class' => 'yii\wechat\sdk\Wechat',
            'appId' => 'xxx',
            'appSecret' => 'xxx',
            'token' => '123'
        ]
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['gii'] = 'yii\gii\Module';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['*']
    ];
} elseif (YII_ENV_PROD) {
    $config['compoents']['assetManager']['bundles'] = require(__DIR__ . '/assets_compressed.php');
}
return $config;
