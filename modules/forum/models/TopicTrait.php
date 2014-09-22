<?php
namespace app\modules\forum\models;

use Yii;
use app\modules\user\models\User;
use app\modules\user\models\Meta;
use app\modules\user\models\Like;
use app\modules\user\models\Hate;
use app\modules\user\models\Favorite;
/**
 * Topic 和 Comment 共用特性类
 * 注意:派生类必须定义 TYPE 常量
 * @package app\modules\forum\models
 */
trait TopicTrait
{
    /**
     * 共用一个表
     * @return string
     */
    public static function tableName()
    {
        return '{{%topic}}';
    }

    /**
     * 自动更新created_at和updated_at时间
     * @return array
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
            ],
        ];
    }

    /**
     * 获取版块
     * @return ActiveQuery
     */
    public function getForum()
    {
        return $this->hasOne(Forum::className(), ['id' => 'fid']);
    }

    /**
     * 获取关联作者
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    /**
     * 获取踩记录
     * @return mixed
     */
    public function getHate()
    {
        return $this->hasOne(Hate::className(), [
            'target_id' => 'id',
        ])->andWhere([
                'uid' => Yii::$app->user->getId(),
                'target_type' => static::TYPE,
                'type' => 'hate'
            ]);
    }

    /**
     * 获取赞记录
     * @return mixed
     */
    public function getLike()
    {
        return $this->hasOne(Like::className(), [
            'target_id' => 'id',
        ])->andWhere([
                'uid' => Yii::$app->user->getId(),
                'target_type' => static::TYPE,
                'type' => 'like',
            ]);
    }

    /**
     * 获取收藏记录
     * @return mixed
     */
    public function getFavorite()
    {
        return $this->hasOne(Favorite::className(), [
            'target_id' => 'id',
        ])->andWhere([
                'uid' => Yii::$app->user->getId(),
                'target_type' => static::TYPE,
                'type' => 'favorite'
            ]);
    }

    /**
     * 踩
     * @param $uid
     * @return bool|string
     */
    public function toggleHate($uid)
    {
        return $this->toggleLikeOrHate($uid, Hate::TYPE);
    }

    /**
     * 顶
     * @param $uid
     * @return bool|string
     */
    public function toggleLike($uid)
    {
        return $this->toggleLikeOrHate($uid, Like::TYPE);
    }

    /**
     * @param $uid
     * @param $type 操作类型, like 或 hate
     * @return bool|string string为错误提示, bool为操作成功还是失败
     */
    protected function toggleLikeOrHate($uid, $type)
    {
        //查找数据库是否有记录
        $model = Meta::find()
            ->where(['or', ['type' => 'like'], ['type' => 'hate']])
            ->andWhere([
                'uid' => $uid,
                'target_type' => static::TYPE
            ])->one();
        $contrary = $return = $active = false;
        if ($model) {
            $num = $model->delete();// 有记录(赞或踩)则取消记录
            if ($model->type == $type) { //相应记录删除后直接返回取消结果
                $return = $num >= 0;
            } else {
                $model = null; // 相对记录需清空查询结果已经生成相应的记录
                $contrary = true;
            }
        }
        if (!$model) { //创建记录
            $model = $type == Like::TYPE ? new Like() : new Hate();
            $model->setAttributes(array(
                'uid' => $uid,
                'target_id' => $this->id,
                'target_type' => static::TYPE,
            ));
            if ($model->save()) {
                $return = $active = true;
            } else {
                $return = array_values($model->getFirstErrors())[0];
            }
        }
        if ($return == true) { // 更新记数
            $attributeName1 = $type . '_count';
            if ($contrary) {
                $attributeName2 = ($type == 'like' ? 'hate' : 'like') . '_count';
                $attributes = [
                    $attributeName1 => $active ? 1 : ($this->$attributeName1 > 0 ? -1 :0),
                    $attributeName2 => $active ? ($this->$attributeName2 > 0 ? -1 :0) : 1
                ];
            } else {
                $attributes = [
                    $attributeName1 => $active ? 1 : ($this->$attributeName1 > 0 ? -1 :0)
                ];
            }
            //更新版块统计
            $this->updateCounters($attributes);
        }
        return $return;
    }

    /**
     * 收藏或取消收藏
     * @param $uid
     * @return bool|string  string为错误提示, bool为操作成功还是失败
     */
    public function toggleFavorite($uid)
    {
        $params = [
            'uid' => $uid,
            'target_id' => $this->id,
            'target_type' => static::TYPE,
        ];
        $favorite = Favorite::findOne($params);
        $active = true;
        if ($favorite) { // 已经收藏了则取消收藏
            $active = false;
            $return = $favorite->delete() >= 0;
        } else {
            $favorite = new Favorite();
            $favorite->setAttributes($params);
            $return = $favorite->save() ?: array_values($favorite->getFirstErrors())[0];
        }
        if ($return == true) { // 更新记数
            $this->updateCounters([ //更新版块统计
                'favorite_count' => $active ? 1 : -1
            ]);
        }
        return $return;
    }

    /**
     * 激活
     * @return bool
     */
    public function toggleActive()
    {
        $active = $this->active ? 0 : 1;
        if ($result = $this->updateAttributes(['active' => $active])) {
            if (static::TYPE === Topic::TYPE) {
                $model = $this->forum;
                $attribute = 'topic_count';
            } else {
                $model = $this->topic;
                $attribute = 'comment_count';
            }
            $model->updateCounters([ //更新版块统计
                $attribute => $active ? 1 : -1
            ]);
        }
        return $result >= 0;
    }
}