<?php
namespace app\modules\forum\models;

use yii\db\ActiveQuery;

class TopicQuery extends ActiveQuery
{
    public function active()
    {
        $this->andWhere(['is_topic' => 1]);
        return $this;
    }
}