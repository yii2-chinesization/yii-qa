<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use app\modules\forum\assets\ForumAsset;
ForumAsset::register($this);
/* @var $this yii\web\View */
/* @var $searchModel app\modules\forum\models\ForumSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Forums';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="forum-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Forum', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
        },
    ]) ?>

</div>
