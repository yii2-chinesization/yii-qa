<?php
use \Yii;
use yii\helpers\Html;
use yii\widgets\ListView;
use app\modules\forum\assets\ForumAsset;
ForumAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\modules\forum\models\Topic */
//$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Topics', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="topic-view">
    <?= $this->render('_topic', [
        'model' => $model
    ]) ?>
    <?= ListView::widget([
        'dataProvider' => $commentDataProvider,
        'itemView' => '_topic',
        'summary' => false,
        'emptyText' => '暂时还没有新的评论',
        'emptyTextOptions' => [
            'class' => 'text-center'
        ]
    ]) ?>
    <?php if (!Yii::$app->user->getIsGuest()): ?>
        <?= $this->render('_commentForm', [
            'model' => $comment
        ]) ?>
    <?php endif ?>
</div>