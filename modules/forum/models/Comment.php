<?php
namespace app\modules\forum\models;

use Yii;
use yii\db\ActiveQuery;
use app\components\db\ActiveRecord;

/**
 * 话题评论
 * @package app\modules\forum\models
 */
class Comment extends ActiveRecord
{
    /**
     * 公用TopicTrait类
     */
    use TopicTrait;
    /**
     * 数据类型
     */
    const TYPE = 'forum_topic_comment';

    public static function find()
    {
        return (new CommentQuery(get_called_class()))->where(['>', 'tid', 0]);
    }

    public function rules()
    {
        return [
            [['fid', 'tid', 'content', 'author_id'], 'required'],
            [['subject'], 'default', 'value' => ''],
            [['active'], 'boolean']
        ];
    }

    /**
     * 获取话题
     */
    public function getTopic()
    {
        return $this->hasOne(Topic::className(), ['id' => 'tid']);
    }
}