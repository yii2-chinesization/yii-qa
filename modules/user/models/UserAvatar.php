<?php
namespace app\modules\user\models;

use yii\helpers\Url;
use app\components\db\ActiveRecord;
use app\components\storage\Storage;

class UserAvatar extends ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_UNVERIFY = 0;
    const STATUS_DELETE = -1;

    public function rules()
    {
        return [
            [['uid', 'sid'], 'required'],
            [['uid', 'sid'], 'integer'],
        ];
    }

    public function scenarios()
    {
        return [
            'upload' => ['author_id', 'path'],
        ];
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->status = self::STATUS_ACTIVE; // 默认上传的头像通过验证
        }
        return parent::beforeSave($insert);
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'created_at',
                ],
            ],
        ];
    }

    public function getStorage()
    {
        return $this->hasOne(Storage::className(), ['sid' => 'id']);
    }

    /**
     * 获取头像Url
     * @return string
     */
    public function getUrl()
    {
        return $this->storage->getUrl() ? : static::getOrginalUrl();
    }

    /**
     * 获取原始的头像url
     * @return string
     */
    public static function getDefaultUrl()
    {
        return Url::to(['/images/anonymous.jpg']);
    }
}