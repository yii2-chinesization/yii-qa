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
        'summary' => false,
        'itemView' => '_topic',
    ]) ?>
    <?php if (!Yii::$app->user->getIsGuest()): ?>
        <?= $this->render('_comment', [
            'model' => $comment
        ]) ?>
    <?php endif ?>
</div>