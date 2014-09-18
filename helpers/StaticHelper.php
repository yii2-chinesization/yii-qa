<?php
namespace app\helpers;

use Yii;

/**
 * 静态文件操作类
 * Class StaticHelper
 * @package app\helpers
 */
class StaticHelper
{
    /**
     * 获取静态文件地址. 如果开启文件优化则会返回优化后的文件地址
     * @param $path
     */
    public static function url($path)
    {
        if (strpos('http://', $path) !== false) {
            return $path;
        } elseif (isset(Yii::$app->params['optimizeUrl'])) {
            return Yii::$app->params['optimizeUrl'] . $path;
        } else {
            return Yii::$app->getHomeUrl() . $path;
        }
    }
}