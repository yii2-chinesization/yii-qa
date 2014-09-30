<?php
namespace app\modules\user\models;

use yii\db\ActiveRecord;

/**
 * 用户操作记录表公用类
 * 注意: 派生类必须定义 TYPE 常量
 * @package app\modules\user\models
 */
trait MetaTrait
{
    public static function tableName()
    {
        return '{{%user_meta}}';
    }

    public function rules()
    {
        return [
            [['type'], 'default', 'value' => static::TYPE],
            [['value'], 'default', 'value' => 1],
            [['uid', 'target_type', 'type', 'value'], 'required']
        ];
    }

    public static function find()
    {
        return parent::find()->where(['type' => static::TYPE]);
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'created_at',
                ],
            ],
        ];
    }
}