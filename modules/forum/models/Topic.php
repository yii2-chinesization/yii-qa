<?php
namespace app\modules\forum\models;

use app\components\db\ActiveRecord;

class Topic extends ActiveRecord
{
    use TopicTrait;

    public static function find()
    {
        return new TopicQuery(get_called_class());
    }
    public function rules()
    {
        return [
            [['fid', 'subject', 'content', 'authorId'], 'required'],
            [['is_topic'], 'default', 'value' => 1]
        ];
    }

    /**
     * 添加评论
     * @param Comment $comment
     * @return bool
     */
    public function addComment(Comment $comment)
    {
        $comment->tid = $this->id;
        $comment->fid = $this->fid;
        $result = $comment->save();
        if ($result) {
            $this->updateAttributes([
                'comment_count' => $this->comment_count + 1
            ]);
            return true;
        }
        return false;
    }

    /**
     * 获取评论列表
     * @return ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::tableName(), ['id' => 'tid']);
    }
}