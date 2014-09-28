<?php
namespace app\modules\forum\models;

use yii\db\ActiveQuery;

class CommentQuery extends ActiveQuery
{
    public function active()
    {
        $this->andWhere(['status' => Comment::STATUS_ACTIVE]);
        return $this;
    }
}