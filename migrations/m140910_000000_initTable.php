<?php

use yii\db\Schema;
use app\models\Tag;
use app\models\TagItem;
use app\models\Config;
use app\models\Storage;
use app\helpers\Console;
use app\components\db\Migration;

class m140910_000000_initTable extends Migration
{
    public function up()
    {
        //初始化设置表
        $tableName = Config::tableName();
        $this->createTable($tableName, [
            'name' => Schema::TYPE_STRING . "(64) NOT NULL COMMENT '名称'",
            'value' => Schema::TYPE_TEXT . " NOT NULL COMMENT '保存的值'",
            'PRIMARY KEY (name)',
        ], $this->tableOptions);

        //附件表
        $tableName = Storage::tableName();
        $this->createTable($tableName, [
            'id' => Schema::TYPE_PK,
            'uid' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户id'",
            'name' => Schema::TYPE_STRING . " NOT NULL DEFAULT '' COMMENT '原始文件名'",
            'path' => Schema::TYPE_STRING . " NOT NULL DEFAULT '' COMMENT '保存路径'",
            'size' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '文件大小'",
            'mime_type' => Schema::TYPE_STRING . "(50) NOT NULL DEFAULT '' COMMENT '文件类型'",
            'bin' => Schema::TYPE_STRING . "(30) NOT NULL DEFAULT '' COMMENT '存储容器'",
            'type' => Schema::TYPE_STRING . "(50) NOT NULL DEFAULT '' COMMENT '所属类型'",
            'status' => Schema::TYPE_BOOLEAN . " NOT NULL DEFAULT '0' COMMENT '附件存储状态'",
            'created_at' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间'",
            'updated_at' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '修改时间'",
        ], $this->tableOptions);
        $this->createIndex('uid', $tableName, 'uid');
        $this->createIndex('type', $tableName, ['type', 'id']);

        //标签表
        $tableName = Tag::tableName();
        $this->createTable($tableName, [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . "(64) NOT NULL COMMENT '标签名'",
            'icon' => Schema::TYPE_STRING . " NOT NULL DEFAULT '' COMMENT '标签图标'",
            'description' => Schema::TYPE_TEXT . " NOT NULL COMMENT '版块介绍'",
            'status' => Schema::TYPE_BOOLEAN . " NOT NULL DEFAULT '0' COMMENT '标签状态'",
            'created_at' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间'",
            'updated_at' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '修改时间'",
        ]);
        $this->createIndex('name', $tableName, 'name', true);
        $this->createIndex('status', $tableName, ['status', 'id']);

        //标签数据表
        $tableName = TagItem::tableName();
        $this->createTable($tableName, [
            'id' => Schema::TYPE_PK,
            'tid' => Schema::TYPE_STRING . "(64) NOT NULL COMMENT '标签id'",
            'target_id' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '目标id'",
            'target_type' => Schema::TYPE_STRING . "(100) NOT NULL DEFAULT '' COMMENT '目标类型'",
            'created_at' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间'"
        ]);
        $this->createIndex('item', $tableName, ['tid', 'target_id', 'target_type'], true);
        $this->createIndex('target_type', $tableName, ['target_type', 'target_id']);
    }

    public function down()
    {
        $this->dropTable(Config::tableName());
        $this->dropTable(Storage::tableName());
    }

    public function dbInit()
    {exit;
        if (Yii::$app->db->dsn !== null) {
            Yii::$app->db->open();
            return;
        }
        Console::output('需要初始并生成数据库设置 ....');
        $dbHost = Console::prompt('请输入数据库地址', ['default' => 'localhost']);
        $dbName = Console::prompt('请输入数据库名称(并确定数据库已建立)', ['default' => Yii::$app->name]);
        $dbUsername = Console::prompt('请输入数据库账户名', ['default' => 'root']);
        $dbPassword = Console::prompt('请输入数据库密码(默认为空)', ['default' => '']);
        $dbPrefix = Console::prompt('请输入数据库表前缀', ['default' => 'pre_']);
    }
}
