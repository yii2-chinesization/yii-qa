<?php
namespace app\models;

use yii\helpers\Url;
use app\components\db\ActiveRecord;

class Storage extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%storage}}';
    }

    public function rules()
    {
        return [
            [['name', 'uid', 'path', 'size', 'mime_type', 'bin'], 'required'],
            ['size', 'integer']
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

    public function getUrl()
    {
        return Url::to('@web/storage' . $this->path);
    }
}