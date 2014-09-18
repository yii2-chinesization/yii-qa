<?php
namespace app\modules\forum\models;

use app\components\db\ActiveRecord;

class Forum extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%forum}}';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'default', 'value' => '']
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
            ],
        ];
    }
}