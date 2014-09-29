<?php
namespace app\models;

use app\components\db\ActiveRecord;

class Tag extends ActiveRecord
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

    public static function tableName()
    {
        return '{{%tag}}';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'unique'],
            [['description'], 'default', 'value' => ''],
        ];
    }

    public static function find()
    {
        return (new TagQuery(get_called_class()));
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
            ],
        ];
    }

    /**
     * 审核通过
     * @return bool
     */
    public function setActive()
    {
        $this->status != static::STATUS_ACTIVE && $this->updateAttributes(['status' => static::STATUS_ACTIVE]);
        return true;
    }

    public function getTagItems()
    {
    }
}