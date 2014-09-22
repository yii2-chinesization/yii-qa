<?php
use yii\helpers\Html;
use yii\bootstrap\NavBar;
use app\widgets\Alert;
use app\widgets\TopMenu;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<meta charset="<?= Yii::$app->charset ?>"/>
    <?= Html::csrfMetaTags() ?>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= Html::encode($this->title) ?> - <?= Yii::$app->name ?></title>
	<?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
    <?php $container = isset($this->params['container']) ? $this->params['container'] : null ?>
    <?php if ($container === false): ?>
        <?= $content ?>
    <?php else: ?>
        <?php
        NavBar::begin([
            'brandLabel' => Yii::$app->name,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-white',
            ],
            'innerContainerOptions' => [
                'class' => 'container container-narrow'
            ]
        ]);
        echo TopMenu::widget();
        NavBar::end();
        ?>
        <div class="container container-narrow mb15">
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    <?php endif ?>
    <footer class="footer">
        <div class="container container-narrow">
            <p class="text-center">Powered by CallMeZ</p>
        </div>
    </footer>
    <a class="back-top" href="javascript:;" data-toggle="backTop" title="滚动到顶部">
        <span class="glyphicon glyphicon-arrow-up"></span>
    </a>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
