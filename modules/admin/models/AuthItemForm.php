<?php
namespace app\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\rbac\Item;

/**
 * RBAC 角色和权限添加验证model
 * @package app\modules\admin\models
 */
class AuthItemForm extends Model
{
    /**
     * @var integer the type of the item. This should be either [[TYPE_ROLE]] or [[TYPE_PERMISSION]].
     */
    public $type;
    /**
     * @var string the name of the item. This must be globally unique.
     */
    public $name;
    /**
     * @var string the item description
     */
    public $description;
    /**
     * @var string name of the rule associated with this item
     */
    public $ruleName;
    /**
     * @var mixed the additional data associated with this item
     */
    public $data;
    /**
     * @var integer UNIX timestamp representing the item creation time
     */
    public $createdAt;
    /**
     * @var integer UNIX timestamp representing the item updating time
     */
    public $updatedAt;

    public function rules()
    {
        return [
            [['type', 'name', 'description'], 'required'],
            ['name', 'match', 'pattern' => '/[A-Za-z0-9_]+/i', 'message' => '关键字只能使用字母数字和-_符号'],
            ['ruleName', 'checkRuleName', 'skipOnEmpty' => false],
            ['data', 'safe']
        ];
    }

    /**
     * ruleName 有外键约束 空字符串不能通过, 设置为null
     * @param $attribute
     * @param $params
     */
    public function checkRuleName($attribute, $params)
    {
        $this->$attribute = $this->$attribute !== '' ? $this->$attribute : null;
    }

    public function attributeLabels()
    {
        return [
            'type' => '类型',
            'name' => '关键字',
            'description' => $this->type == Item::TYPE_ROLE ? '角色名称' : '权限描述',
            'ruleName' => '规则名',
            'data' => '内容',
            'createdAt' => '创建时间',
            'updatedAt' => '修改时间'
        ];
    }

    /**
     * 创建或修改item
     * @return bool
     */
    public function saveItem(Item $item = null)
    {
        if (!$this->validate()) {
            return false;
        }
        $authManager = Yii::$app->getAuthManager();

        if ($item === null) { // 创建Item
            if ($this->type == Item::TYPE_ROLE) { // 判断类型
                $methodGet = 'getRole';
                $methodCreate = 'createRole';
            } else {
                $methodGet = 'getPermission';
                $methodCreate = 'createPermission';
            }
            if ($item = $authManager->$methodGet($this->name)) {
                return $this->addError('name', '关键字已存在');
            }
            $item = $authManager->$methodCreate($this->name); // 否则创建item
            Yii::configure($item, $this->getAttributes());
            return $authManager->add($item);
        } else { // 修改item
            if ($this->type != $item->type) { //类型必须一样
                $this->addError('name', "{$item->name}类型不正确.不能修改");
            }
            $name = $item->name;
            Yii::configure($item, $this->getAttributes());
            return $authManager->update($name, $item);
        }
    }
}
