<?php
namespace app\modules\forum\models;

use yii\db\ActiveQuery;
use app\components\db\ActiveRecord;

/**
 * 话题评论
 * @package app\modules\forum\models
 */
class Comment extends ActiveRecord
{
    /**
     * 和Topic共用一个表
     */
    use TopicTrait;

    public static function find()
    {
        return new CommentQuery(get_called_class());
    }

    public function rules()
    {
        return [
            [['fid', 'tid', 'content', 'author_id'], 'required'],
            [['is_topic'], 'default', 'value' => false],
            [['subject'], 'default', 'value' => '']
        ];
    }
}