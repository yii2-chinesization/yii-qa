<?php

use yii\db\Schema;
use app\helpers\Console;
use app\components\db\Migration;
use app\modules\admin\helpers\AdminHelper;

class m140910_100100_initAdminTable extends Migration
{
    public function up()
    {
        $this->initMenu();
    }

    public function down()
    {
    }

    public function initMenu()
    {
        Console::output('初始化后台菜单 ....');
        /* ============= 添加后台菜单 ============= */
        //用户
        AdminHelper::addMenu('user', ['/user/admin/user/index'], '用户管理', [
            'icon' => 'fa-user',
            'priority' => 10
        ]);

        //rbac
        AdminHelper::addMenu('rbac', ['/user/admin/rbac/index'], '角色权限', [
            'subShow' => false,
            'icon' => 'fa-group',
            'priority' => 20
        ]);
        AdminHelper::addSubMenu('rbac', 'roles', ['/user/admin/rbac/roles'], '角色列表');
        AdminHelper::addSubMenu('rbac', 'permissions', ['/user/admin/rbac/permissions'], '权限列表');

        //系统设置
        AdminHelper::addMenu('system', ['/admin/system/index'], '系统设置', [
            'icon' => 'fa-gears',
            'priority' => 20
        ]);

        Console::output('初始化后台菜单完成 ....');
    }
}
