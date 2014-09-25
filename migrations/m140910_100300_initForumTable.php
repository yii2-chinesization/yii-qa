<?php

use yii\db\Schema;
use app\helpers\Console;
use app\components\db\Migration;
use app\modules\forum\models\Forum;
use app\modules\forum\models\Topic;
use app\modules\forum\models\Comment;

class m140910_100300_initForumTable extends Migration
{
    public function up()
    {
        //版块
        $tableName = Forum::tableName();
        $this->createTable($tableName, [
            'id' => Schema::TYPE_PK,
            'parent' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '父版块'",
            'name' => Schema::TYPE_STRING . "(100) NOT NULL COMMENT '版块名称'",
            'description' => Schema::TYPE_TEXT . " NOT NULL COMMENT '版块介绍'",
            'cover' => Schema::TYPE_STRING . " NOT NULL DEFAULT '' COMMENT '版块封面'",
            'icon' => Schema::TYPE_STRING . " NOT NULL DEFAULT '' COMMENT '版块图标'",
            'topic_count' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '话题数'",
            'created_at' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间'",
            'updated_at' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '修改时间'",
        ], $this->tableOptions);
        $this->createIndex('parent', $tableName, 'parent', true);
        $this->forumInit();

        //话题
        $tableName = Topic::tableName();
        $this->createTable($tableName, [
            'id' => Schema::TYPE_PK,
            'fid' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '版块ID'",
            'tid' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '所属话题ID.默认为0, 表示为话题,否则为评论'",
            'active' => Schema::TYPE_BOOLEAN . " NOT NULL DEFAULT '0' COMMENT '是否话题,否则为话题评论'",
            'author_id' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '作者ID'",
            'subject' => Schema::TYPE_STRING . " NOT NULL COMMENT '话题的主题'",
            'content' => Schema::TYPE_TEXT . " NOT NULL COMMENT '话题内容'",
            'view_count' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '查看数'",
            'comment_count' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '评论数'",
            'favorite_count' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '收藏数'",
            'like_count' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '喜欢数'",
            'hate_count' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '讨厌数'",
            'created_at' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间'",
            'updated_at' => Schema::TYPE_INTEGER . " UNSIGNED NOT NULL DEFAULT '0' COMMENT '修改时间'",
        ]);
        $this->createIndex('fid', $tableName, 'fid');
        $this->topicInit();

        $this->commentInit();
    }

    public function down()
    {
        $this->dropTable(Forum::tableName());
        $this->dropTable(Topic::tableName());
    }

    public $forumId;
    public function forumInit()
    {
        Console::output('创建默认版块 ....');
        $forum = new Forum();
        $forum->setAttributes([
            'name' => '默认版块',
            'description' => '默认版块描述'
        ]);
        if ($forum->save()) {
            $message = '成功';
            $this->forumId = $forum->primaryKey;
        } else {
            $message = '失败';
        }
        Console::output('创建默认版块' . $message);
    }

    public $topic;
    public function topicInit()
    {
        if ($this->forumId === null) {
            Console::output('无法创建默认话题,因为没有默认归属版块 ....');
            return;
        }
        Console::output('创建默认话题 ....');
        $topic = new Topic();
        $topic->setAttributes([
            'fid' => $this->forumId,
            'author_id' => 1,
            'subject' => '默认话题',
            'content' => '默认话题内容'
        ]);
        if ($topic->save()) {
            $topic->toggleActive(); //激活
            $message = '成功';
            $this->topic = $topic;
        } else {
            $message = '失败';
        }
        Console::output('创建默认话题' . $message);
    }

    public function commentInit()
    {
        if (!$this->topic) {
            return;
        }
        Console::output('创建默认评论 ....');
        $comment = new Comment();
        $comment->setAttributes([
            'author_id' => 1,
            'content' => '默认评论内容'
        ]);

        $message = $this->topic->addComment($comment, true) ? '成功' : '失败';
        Console::output('创建默认评论' . $message);
    }
}
