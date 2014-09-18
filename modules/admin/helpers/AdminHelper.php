<?php
namespace app\modules\admin\helpers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\base\InvalidConfigException;

class AdminHelper
{

    public static function getMenu($menuKey = null)
    {
        return Yii::$app->get('config')->get('menu', []);
    }

    public static function setMenu($menu)
    {
        return Yii::$app->get('config')->set('menu', $menu);
    }

    /**
     * 添加菜单(如果菜单已存在则覆盖)
     * @param $name 菜单键值
     * @param $link
     * @param array $options
     */
    public static function addMenu($menuKey, $link, $title = null, array $options = [])
    {
        $menus = static::getMenu();

        $menu = [
            'link' => $link,
            'title' => $title ? : $menuKey,
            'icon' => isset($options['icon']) ? $options['icon'] : 'fa-gear',
            'priority' => isset($options['priority']) ? (int)$options['priority'] : 10 //  优先级
        ];

        if (isset($options['parent'])) { //子菜单
            if (!array_key_exists($options['parent'], $menus)) {
                throw new InvalidConfigException("The menu {$options['parent']} is not exists, Can't set submenu.");
            }
            $menus[$options['parent']]['submenu'][$menuKey] = $menu;
            ArrayHelper::multisort($menus[$options['parent']]['submenu'], 'priority'); // 子菜单排序
        } else {
            $menu['subShow'] = isset($options['subShow']) && $options['subShow'] !== false; // 是否在子菜单显示

            !isset($menus[$menuKey]) && $menus[$menuKey] = [];
            $menus[$menuKey] = array_merge($menus[$menuKey], $menu);
            ArrayHelper::multisort($menus[$menuKey], 'priority'); // 菜单排序
        }

        return static::setMenu($menus);
    }

    /**
     * 添加子菜单
     * @param $parent
     * @param $title
     * @param $link
     * @param array $options
     */
    public static function addSubmenu($parent, $menuKey, $link, $title = null, array $options = [])
    {
        $options['parent'] = $parent;
        !isset($options['icon']) && $options['icon'] = 'fa-angle-double-right';
        return static::addMenu($menuKey, $link, $title, $options);
    }
}