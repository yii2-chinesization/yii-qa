<?php
namespace app\models;

use app\components\db\ActiveRecord;

class TagData extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%tag_data}}';
    }

    public function rules()
    {
        return [
            [['name'], 'required']
        ];
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