<?php

use yii\db\Schema;
use yii\helpers\Console;
use app\components\db\Migration;
use app\modules\user\models\User;
use app\modules\user\models\Meta;
use app\modules\user\models\Avatar;
use app\modules\user\models\RegisterForm;

class m140910_100200_initUserTable extends Migration
{
    public function up()
    {
        //用户
        $tableName = User::tableName();
        $this->createTable($tableName, [
            'id' => Schema::TYPE_PK,
            'email' => Schema::TYPE_STRING . "(40) NOT NULL COMMENT '邮箱'",
            'username' => Schema::TYPE_STRING . "(20) NOT NULL COMMENT '用户名'",
            'auth_key' => Schema::TYPE_STRING . "(32) NOT NULL COMMENT '加密秘钥'",
            'password_hash' => Schema::TYPE_STRING . " NOT NULL COMMENT 'hash密码'",
            'password_reset_token' => Schema::TYPE_STRING . " NOT NULL DEFAULT '' COMMENT '密码重置秘钥'",

            'followers' => Schema::TYPE_SMALLINT . "(6) UNSIGNED NOT NULL DEFAULT '0' COMMENT '粉丝数'",
            'following' => Schema::TYPE_SMALLINT . "(6) UNSIGNED NOT NULL DEFAULT '0' COMMENT '关注数'",
            'photos' => Schema::TYPE_SMALLINT . "(6) UNSIGNED NOT NULL DEFAULT '0' COMMENT '图片数'",

            'avatar_sid' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '头像storage id'",

            'status' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 10',

            'last_login_ip' => Schema::TYPE_STRING . "(32) NOT NULL DEFAULT '' COMMENT '最后登录IP'",
            'last_visit_at' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '最后访问时间'",
            'created_at' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间'",
            'updated_at' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '修改时间'",
        ], $this->tableOptions);
        $this->createIndex('username', $tableName, 'username', true);
        $this->createIndex('email', $tableName, 'email');
        $this->createIndex('status', $tableName, 'status');
        $this->createIndex('created_at', $tableName, 'created_at');
        $this->generateFounderUser();

        //用户头像
        $tableName = Avatar::tableName();
        $this->createTable($tableName, [
            'id' => Schema::TYPE_PK,
            'uid' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户id'",
            'sid' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '图片存储id'",
            'default' => Schema::TYPE_BOOLEAN . " NOT NULL DEFAULT '0' COMMENT '是否默认头像'",
            'status' => Schema::TYPE_BOOLEAN . " NOT NULL DEFAULT '0' COMMENT '状态'",
            'created_at' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间'"
        ], $this->tableOptions);
        $this->createIndex('uid', $tableName, 'uid');
        $this->createIndex('sid', $tableName, 'sid');
        $this->createIndex('status', $tableName, ['status', 'uid']);
        $this->createIndex('default', $tableName, ['default', 'status', 'uid']);

        //用户操作数据表 (收藏, 赞, 踩...) 数据保存
        $tableName = Meta::tableName();
        $this->createTable($tableName, [
            'id' => Schema::TYPE_PK,
            'uid' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户id'",
            'type' => Schema::TYPE_STRING . "(100) NOT NULL DEFAULT '' COMMENT '操作类型'",
            'value' => Schema::TYPE_STRING . " NOT NULL DEFAULT '' COMMENT '操作类型值'",
            'target_id' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '目标id'",
            'target_type' => Schema::TYPE_STRING . "(100) NOT NULL DEFAULT '' COMMENT '目标类型'",
            'created_at' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间'",
        ], $this->tableOptions);
        $this->createIndex('item', $tableName, ['uid', 'type', 'target_id', 'target_type'], true);
        $this->createIndex('target_type', $tableName, ['target_type', 'target_id']);

    }

    public function down()
    {
        $this->dropTable(User::tableName());
        $this->dropTable(Avatar::tableName());
        $this->dropTable(Meta::tableName());
    }

    /**
     * 创建 创始人用户
     */
    public function generateFounderUser()
    {
        $result = $this->saveUserData(new RegisterForm());
        echo "创始人创建" . ($result ? '成功' : "失败, 请手动创建创始人用户") . PHP_EOL;
    }

    /**
     * 用户创建交互程序
     * @param $userForm
     * @return mixed
     */
    private function saveUserData($userForm)
    {
        $authManager = Yii::$app->authManager;
        $founder = $authManager->getRole('founder');

        $userForm->username = Console::prompt('请先创建创始人用户', ['default' => 'admin']);
        $userForm->email = Console::prompt('请先创建创始人邮箱', ['default' => 'admin@admin.com']);
        $userForm->password = Console::prompt('请先创建创始人密码', ['default' => 'admin']);

        if (!($user = $userForm->register())) {
            echo '输入数据验证错误:' . PHP_EOL;
            foreach ($userForm->getErrors() as $k => $v) {
                echo $k . ':' . PHP_EOL . implode(PHP_EOL, $v) . PHP_EOL;
            }
            echo '请重新输入' . PHP_EOL;
            $this->saveUserData($user);
        }
        $user->setAttributes([ // 设置创始人信息
        ]);

        $success = $user->save();
        $uid = $success ? $user->id : 1; // 用户创建成功则指定用户id,否则指定id为1的用户为创始人.

        $founder && $authManager->assign($founder, $uid); // 指定创始人身份

        return $success;
    }
}
