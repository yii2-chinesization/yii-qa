<?php
namespace app\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

/**
 * 全局导航菜单
 * @package app\widgets
 */
class TopMenu extends Widget
{
    public function run()
    {
        return $this->render('topMenu', [
            'items' => $this->items()
        ]);
    }

    /**
     * 菜单选项
     * @return array
     */
    public function items()
    {
        $user = Yii::$app->getUser();
        $identity = $user->getIdentity();
        if ($user->getIsGuest()) {
            $items = [
                [
                    'label' => '登录',
                    'url' => $user->loginUrl,
                    'linkOptions' => [
                        'id' => 'login',
                        'data-toggle' => "modal",
                        'data-target' => '#loginModal'
                    ]
                ],
                [
                    'label' => '注册',
                    'url' => $user->registerUrl,
                    'linkOptions' => [
                        'id' => 'register',
                        'data-toggle' => "modal",
                        'data-target' => '#registerModal'
                    ]
                ],
            ];
        } else {
            $items = [
                [
                    'label' => Html::img($identity->getAvatarUrl([
                            'width' => 32,
                            'height' => 32
                        ]), [
                            'class' => 'avatar-xs',
                        ]) . ' ' . $identity->username,
                    'items' => [
                        [
                            'label' => '<span class="glyphicon glyphicon-home"></span> 个人中心',
                            'url' => $user->homeUrl
                        ],
                        [
                            'label' => '<span class="glyphicon glyphicon-user"></span> 后台管理',
                            'url' => ['/admin'],
                            'visible' => $user->can('visitAdmin')
                        ],
                        '<li class="divider"></li>',
                        [
                            'label' => '<span class="glyphicon glyphicon-off"></span> 退出登录',
                            'url' => $user->logoutUrl
                        ]
                    ]
                ]
            ];
        }

        return $items;
    }
}
