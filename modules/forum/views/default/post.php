<?php

use yii\helpers\Html;
use app\modules\forum\assets\ForumAsset;
ForumAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\modules\forum\models\Forum */

$this->title = '发表话题';
$this->params['breadcrumbs'][] = ['label' => 'Forums', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="forum-topic-post">
    <h2><?= Html::encode($this->title) ?></h2>
    <?= $this->render('_topicForm', [
        'model' => $topic,
    ]) ?>
</div>
