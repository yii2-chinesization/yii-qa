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
     * 审核通过
     */
    const STATUS_ACTIVE = 1;
    /**
     * 审核
     */
    const STATUS_AUDIT = 0;
    /**
     * 已删除
     */
    const STATUS_DELETED = -1;

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
        return (new CommentQuery(get_called_class()))->andWhere(['>', 'tid', 0]);
    }

    public function rules()
    {
        return [
            [['fid', 'tid', 'content', 'author_id'], 'required'],
            [['subject'], 'default', 'value' => ''],
            [['status'], 'in', 'range' => [static::STATUS_ACTIVE, static::STATUS_AUDIT, static::STATUS_DELETED]]
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