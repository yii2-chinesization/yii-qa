<?php
namespace app\modules\forum\models;

use app\modules\user\models\User;

trait TopicTrait
{
    public static function tableName()
    {
        return '{{%topic}}';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
            ],
        ];
    }

    /**
     * 获取关联作者
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'authorId']);
    }
}