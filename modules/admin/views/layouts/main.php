<?php
use yii\helpers\Html;
use yii\widgets\Menu;
use yii\widgets\Breadcrumbs;
use app\widgets\Alert;
use app\modules\admin\assets\AdminAsset;
use app\modules\admin\helpers\AdminHelper;

AdminAsset::register($this);
$user = Yii::$app->getUser();
$identity = $user->getIdentity();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <title><?= Html::encode($this->title) ?> - <?= Yii::$app->name ?> 后台管理</title>
    <?php $this->head() ?>
</head>
<body class="skin-blue">
<?php $this->beginBody() ?>
<header class="header">
    <a class="logo" href="../index.html"><?= Yii::$app->name ?></a>
    <nav class="navbar navbar-static-top" role="navigation">
        <a role="button" data-toggle="offcanvas" class="navbar-btn sidebar-toggle" href="#">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="navbar-right">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="glyphicon glyphicon-user"></i>
                        <span> <?= Html::encode($identity->username) ?> <i class="caret"></i></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header bg-light-blue">
                            <img src="<?= $identity->getAvatarUrl() ?>" class="img-circle">

                            <p>
                                <?= Html::encode($identity->username) ?>
                                - <?= Html::encode($identity->getRole()->description) ?>
                                <small>最后访问: <?= date('Y-m-d H:i:s', $identity->last_visit_at) ?></small>
                            </p>
                        </li>
                        <li class="user-body">
                            <div class="col-xs-4 text-center">
                                <strong><? //= $identity->following ?></strong> 关注
                            </div>
                            <div class="col-xs-4 text-center">
                                <strong><? //= $identity->followers ?></strong> 粉丝
                            </div>
                            <div class="col-xs-4 text-center">
                                <strong><? //= $identity->photos ?></strong> 图片
                            </div>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <?=
                                Html::a('个人中心', ['/user/home/index', 'id' => $user->id], [
                                    'class' => 'btn btn-default btn-flat'
                                ]) ?>
                            </div>
                            <div class="pull-right">
                                <?=
                                Html::a('退出登录', $user->logoutUrl, [
                                    'class' => 'btn btn-default btn-flat'
                                ]) ?>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
<div class="wrapper row-offcanvas row-offcanvas-left">
    <aside class="left-side sidebar-offcanvas">
        <section class="sidebar">
            <form action="#" method="get" class="sidebar-form">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                            <button type="submit" name="seach" id="search-btn" class="btn btn-flat"><i
                                    class="fa fa-search"></i></button>
                        </span>
                </div>
            </form>
            <?=
            Menu::widget([
                'encodeLabels' => false,
                'activateParents' => true,
                'options' => [
                    'class' => 'sidebar-menu'
                ],
                'submenuTemplate' => "\n<ul class=\"treeview-menu\">\n{items}\n</ul>\n",
                'items' => call_user_func(function ($menus) {
                    $return = [];
                    $activeItem = isset($this->params['activeMenu']) ? $this->params['activeMenu'] : null;
                    foreach ($menus as $k => $menu) {
                        $submenus = !empty($menu['submenu']) ? $menu['submenu'] : false;
                        $notice = isset($menu['notice']) ? $menu['notice'] : ($submenus ? '<i class="fa fa-angle-left pull-right"></i>' : '');
                        $return[$k] = [
                            'url' => $submenus ? 'javascript:;' : $menu['link'],
                            'label' => '<i class="fa ' . $menu['icon'] . '"></i> ' . $menu['title'] . $notice,
                            'options' => [
                                'class' => $submenus ? 'treeview' : ''
                            ],
                            'active' => $activeItem == $k ? true : null

                        ];
                        if ($submenus) {
                            $menu['subShow']&& $return[$k]['items'][] = [
                                'url' => $menu['link'],
                                'label' => '<i class="fa fa-angle-double-right"></i> ' . $menu['title'],
                                'active' => $return[$k]['active']
                            ];
                            foreach ($submenus as $key => $submenu) {
                                $return[$k]['items'][] = [
                                    'url' => $submenu['link'],
                                    'label' => '<i class="fa ' . $submenu['icon'] . '"></i> ' . $submenu['title'],
                                    'active' => $activeItem == implode('/', [$k, $key]) ? true : null
                                ];
                            }
                        }
                    }
                    return $return;
                }, AdminHelper::getMenu())
            ]) ?>
        </section>
    </aside>
    <aside class="right-side">
        <section class="content-header">
            <h1>
                <?= Html::encode($this->title) ?>
                <?php if (!empty($this->params['smallTitle'])): ?>
                    <small><?= Html::encode($this->params['smallTitle']) ?></small>
                <?php endif ?>
            </h1>
            <?= Breadcrumbs::widget([
                'tag' => 'ol',
                'homeLink' => [
                    'url' => ['/admin'],
                    'label' => '后台首页'
                ],
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []
            ]) ?>
        </section>
        <section class="content">
            <?= Alert::widget() ?>
            <?= $content ?>
        </section>
    </aside>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
