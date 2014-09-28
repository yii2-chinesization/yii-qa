<?php
namespace app\modules\forum\models;

use yii\db\ActiveQuery;

class TopicQuery extends ActiveQuery
{
    public function active()
    {
        $this->andWhere(['status' => Topic::STATUS_ACTIVE]);
        return $this;
    }
}