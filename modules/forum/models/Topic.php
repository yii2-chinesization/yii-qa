<?php
namespace app\modules\forum\models;

use Yii;
use app\components\db\ActiveRecord;

class Topic extends ActiveRecord
{
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
            [['active'], 'boolean']
        ];
    }

    /**
     * 获取评论列表
     * @return ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['tid' => 'id'])->active();
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
            $active && $comment->toggleActive();
            return true;
        }
        return false;
    }
}