<?php
use yii\helpers\Html;
?>
<div class="topic-list">
    <div class="row">
        <div class="col-xs-12">
            <div class="info">
                <span class="comment <?= $model->comment_count ? 'commented' : '' ?>" title="<?= $model->comment_count ?> 个评论">
                    <span><?= $model->comment_count ?></span>
                    <span class="glyphicon glyphicon-<?= $model->comment_count ? 'ok' : 'comment' ?> pull-right"></span>
                </span>
                <span class="like" title="<?= $model->like_count ?> 个投票">
                    <span><?= $model->like_count ?></span>
                    <span class="glyphicon glyphicon-thumbs-up pull-right"></span>
                </span>
            </div>
            <div class="summary">
                <?= Html::a(Html::img($model->author->getAvatarUrl(), ['class' => 'avatar']), ['topic/view', 'id' => $model->id], [
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'bottom',
                    'title' => Html::encode($model->author->username),
                    'class' => 'pull-right'
                ]) ?>
                <h5><?= Html::a(Html::encode($model->subject), ['topic/view', 'id' => $model->id]) ?></h5>
                <div class="text-muted">
                    <span> <span class="glyphicon glyphicon-eye-open"></span> <?= $model->view_count ?></span>&nbsp;
                    <span> <span class="glyphicon glyphicon-tags"></span> tags</span>&nbsp;
                    <span> <span class="glyphicon glyphicon-time"></span> <?= date('Y-m-d H:i:s', $model->updated_at) ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
