<?php

use yii\db\Schema;
use app\models\Config;
use app\models\Storage;
use app\components\db\Migration;

class m140910_000000_initTable extends Migration
{
    public function up()
    {
        //初始化设置表
        $this->createTable(Config::tableName(), [
            'name' => Schema::TYPE_STRING . "(64) NOT NULL COMMENT '名称'",
            'value' => Schema::TYPE_TEXT . " NOT NULL COMMENT '保存的值'",
            'PRIMARY KEY (name)',
        ], $this->tableOptions);

        //附件表
        $tableName = Storage::tableName();
        $this->createTable(Storage::tableName(), [
            'id' => Schema::TYPE_PK,
            'uid' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户id'",
            'name' => Schema::TYPE_STRING . " NOT NULL DEFAULT '' COMMENT '原始文件名'",
            'path' => Schema::TYPE_STRING . " NOT NULL DEFAULT '' COMMENT '保存路径'",
            'size' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '文件大小'",
            'mime_type' => Schema::TYPE_STRING . " NOT NULL DEFAULT '' COMMENT '文件类型'",
            'bin' => Schema::TYPE_STRING . " NOT NULL DEFAULT '' COMMENT '存储容器'",
            'type' => Schema::TYPE_STRING . " NOT NULL DEFAULT '' COMMENT '所属类型'",
            'status' => Schema::TYPE_SMALLINT . " NOT NULL DEFAULT '0' COMMENT '附件存储状态'",
            'created_at' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间'",
            'updated_at' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '修改时间'",
        ], $this->tableOptions);
        $this->createIndex('uid', $tableName, 'uid');
        $this->createIndex('type', $tableName, 'type');

    }

    public function down()
    {
        $this->dropTable(Config::tableName());
        $this->dropTable(Storage::tableName());
    }
}
