<?php
namespace app\modules\forum\models;

use yii\db\ActiveQuery;

class TopicQuery extends ActiveQuery
{
    public function active()
    {
        $this->andWhere(['active' => 1]);
        return $this;
    }
}