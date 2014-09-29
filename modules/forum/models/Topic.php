<?php
namespace app\modules\forum\models;

use Yii;
use app\models\Tag;
use app\models\TagItem;
use app\components\db\ActiveRecord;

class Topic extends ActiveRecord
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
    const TYPE = 'forum_topic';

    public static function find()
    {
        return (new TopicQuery(get_called_class()))->where(['tid' => 0]);
    }

    public function rules()
    {
        return [
            [['fid', 'subject', 'content', 'author_id'], 'required'],
            [['status'], 'in', 'range' => [static::STATUS_ACTIVE, static::STATUS_AUDIT, static::STATUS_DELETED]]
        ];
    }

    /**
     * 获取评论列表
     * @return ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['tid' => 'id']);
    }

    /**
     * 添加评论
     * @param Comment $comment
     * @param bool $active 激活
     * @return bool
     */
    public function addComment(Comment $comment, $active = false)
    {
        $comment->setAttributes([
            'tid' => $this->id,
            'fid' => $this->fid
        ]);
        $result = $comment->save();
        if ($result) {
            $active && $comment->setActive();
            return true;
        }
        return false;
    }

    /**
     * 获取帖子标签
     * @return mixed
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'id'])
            ->viaTable(TagItem::tableName(), ['target_id' => 'id'], function($model) {
                $model->andWhere(['target_type' => static::TYPE]);
            });
    }

    /**
     * 获取帖子标签记录
     * @return mixed
     */
    public function getTagItems()
    {
        return $this->hasMany(TagItem::className(), ['target_id' => 'id'])
            ->andWhere(['target_type' => static::TYPE]);
    }

    /**
     * 添加标签
     * @param array $tags
     * @return bool
     */
    public function addTags(array $tags)
    {
        $return = false;
        $tagItem = new TagItem();
        foreach ($tags as $tag) {
            $_tagItem = clone $tagItem;
            $_tagItem->setAttributes([
                'tid' => $tag->id,
                'target_id' => $this->id,
                'target_type' => static::TYPE
            ]);
            if ($_tagItem->save() && $return == false) {
                $return = true;
            }
        }
        return $return;
    }
}