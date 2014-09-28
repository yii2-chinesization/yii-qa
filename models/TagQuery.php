<?php
namespace app\models;

use yii\db\ActiveQuery;

class TagQuery extends ActiveQuery
{
    public function active()
    {
        $this->andWhere(['status' => Tag::STATUS_ACTIVE]);
        return $this;
    }
}