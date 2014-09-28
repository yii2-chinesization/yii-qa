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

    public function getTopics()
    {
        return $this->hasMany(Topic::className(), ['fid' => 'id']);
    }

    /**
     * 发表新帖
     * @param Topic $topic
     * @param bool $active 激活
     * @return bool
     */
    public function addTopic(Topic $topic, $active = false)
    {
        $topic->setAttributes([
            'fid' => $this->id,
        ]);
        $result = $topic->save();
        if ($result) {
            $active && $topic->setActive();
            return true;
        }
        return false;
    }
}