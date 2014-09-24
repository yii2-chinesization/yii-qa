<?php
namespace app\models;

use app\components\db\ActiveRecord;

class Tag extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%tag}}';
    }

    public function rules()
    {
        return [
            [['name'], 'required']
        ];
    }
}