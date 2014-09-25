<?php
namespace app\helpers;

class Console extends \yii\helpers\BaseConsole
{

    /**
     * 在windows cmd 情况下的中文输出乱码问题
     * @param string $string
     * @return bool|int
     */
    public static function stdout($string)
    {
        static::isRunningOnWindows() && $string = iconv('utf-8', 'gbk', $string);
        return fwrite(\STDOUT, $string);
    }
}