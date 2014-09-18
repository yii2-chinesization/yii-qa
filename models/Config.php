<?php
namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use app\components\db\ActiveRecord;

class Config extends ActiveRecord
{
    public function rules()
    {
        return [
            [['name', 'value'], 'required'],
        ];
    }

    public function beforeSave($insert)
    {
        $this->setAttribute('value', serialize($this->getAttribute('value'))); // 序列化保存 value 数据
        parent::beforeSave($insert);
    }

    public function afterFind()
    {
        $this->setAttribute('value', unserialize($this->getAttribute('value'))); // value 数据反序列化
        parent::afterFind();
    }

    /**
     * 按数组格式取出值, 作为Config调用 [
     *  'name' => 'value'
     * ]
     * @return array
     */
    public static function getData()
    {
        return ArrayHelper::map(
            static::find()->all(),
            'name',
            'value'
        );
    }


    /**
     * Config
     * @param array $data
     */
    public static function saveData(array $data)
    {
        $newData = [];
        foreach ($data as $name => $value) {
            $newData[] = [$name, serialize($value)]; // 序列化保存 value 数据
        }
        return static::getDb()->createCommand()->batchReplace(static::tableName(), [
            'name',
            'value'
        ], $newData, true)->execute();
    }
}

?>