<?php
namespace app\modules\forum\models;

use yii\db\ActiveQuery;

class CommentQuery extends ActiveQuery
{
    public function active()
    {
        $this->andWhere(['is_topic' => 0]);
        return $this;
    }
}