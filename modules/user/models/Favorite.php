<?php
namespace app\modules\user\models;

/**
 * 收藏数据表
 * @package app\modules
 */
class Favorite extends Meta
{
    use MetaTrait;
    const TYPE = 'favorite';
}