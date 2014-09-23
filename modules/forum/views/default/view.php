<?php

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Tabs;
use yii\widgets\ListView;
use yii\widgets\DetailView;
use yii\data\ActiveDataProvider;
use app\modules\forum\assets\ForumAsset;
ForumAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\modules\forum\models\Forum */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Forums', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="forum-view">
    <h3><?= Html::encode($model->name) ?></h3>
    <p><?= Html::encode($model->description) ?></p>
    <p>
        说点什么把?
        <a href="<?= Url::to(['post', 'id' => $model->id]) ?>" class="btn btn-success">我要发表</a>
    </p>
    <ul class="nav nav-tabs mb10">
        <?php $sort = Yii::$app->request->getQueryParam('sort') ?>
        <li <?php if (!in_array($sort, $sortArray)): ?>class="active"<?php endif ?>><a href="<?= Url::to(['', 'id' => $model->id]) ?>">最新的</a></li>
        <li <?php if ($sort == 'hotest'): ?>class="active"<?php endif ?>><a href="<?= Url::to(['', 'id' => $model->id, 'sort' => 'hotest']) ?>">热门的</a></li>
        <li <?php if ($sort == 'uncommented'): ?>class="active"<?php endif ?>><a href="<?= Url::to(['', 'id' => $model->id, 'sort' => 'uncommented']) ?>">未评论</a></li>
    </ul>
    <?= ListView::widget([
        'dataProvider' => $topicDataProvider,
        'itemOptions' => ['class' => 'item'],
        'summary' => false,
        'itemView' => '_topic',
    ]) ?>
</div>
