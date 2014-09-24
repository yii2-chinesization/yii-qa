<?php
namespace app\modules\user\models;

use app\components\db\ActiveRecord;

/**
 * 用户操作数据记录类
 * @package app\modules\user\models
 */
class Meta extends ActiveRecord
{
    use MetaTrait;
    const TYPE = 'meta';
}