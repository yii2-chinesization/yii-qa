<?php

require Yii::getAlias('@yii/rbac/migrations/m140506_102106_rbac_init.php');

/**
 * rbac
 */
class m140910_000001_initRbacTable extends m140506_102106_rbac_init
{
    public function up()
    {
        if($this->isDbAuth()) {
            parent::up();
            $this->rbacInit();
        }
    }

    public function down()
    {
        $this->isDbAuth() && parent::down();
    }

    /**
     * 判断是否db类型的authManager.
     * @return
     */
    public function isDbAuth()
    {
        static $isDbAuth;
        if ($isDbAuth === null) {
            $auth = Yii::$app->authManager;
            $isDbAuth = $auth && property_exists($auth, 'db');
        }
        return $isDbAuth;
    }

    /**
     * 初始化rbac 默认设置
     */
    public function rbacInit()
    {
        echo PHP_EOL . '初始化RBAC数据 ....' . PHP_EOL;

        $auth = Yii::$app->authManager;

        /* ================= 权限 ================= */
        $visitAdmin = $auth->createPermission('visitAdmin');
        $visitAdmin->description = '访问后台管理界面';
        $auth->add($visitAdmin);

        /* ================= 身份 ================= */
        $guest = $auth->createRole('guest'); // 匿名用户
        $guest->description = '匿名用户';
        $auth->add($guest);

        $user = $auth->createRole('user'); //普通用户
        $user->description = '普通用户';
        $auth->add($user, $guest); //普通用户 > 匿名用户

        $admin = $auth->createRole('admin'); // 管理员
        $admin->description = '管理员';
        $auth->add($admin);
        $auth->addChild($admin, $user); // 管理员 > 普通用户
        $auth->addChild($admin, $visitAdmin); // 管理员可以访问后台

        $founder = $auth->createRole('founder'); // 创始人
        $founder->description = '创始人';
        $auth->add($founder);
        $auth->addChild($founder, $admin); // 创始人 > 管理员

        echo PHP_EOL . '初始化RBAC数据完成' . PHP_EOL;
    }
}
