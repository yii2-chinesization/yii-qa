<?php
use yii\helpers\Html;
use yii\helpers\Markdown;
?>
<div class="clearfix">
<?php if ($model->is_topic) : ?>
    <?php $this->title = Html::encode($model->subject) ?>
    <div class="topic-title">
        <h3><?= Html::encode($this->title) ?></h3>
    </div>
<?php endif ?>
<div class="topic-cell">
    <a href="#" class="topic-like">
        <span class="num">0</span>
        <span class="glyphicon glyphicon-thumbs-up pull-left"></span> 赞
    </a>
    <a href="#" class="topic-hate" data-toggle="tooltip" data-placement="right" rel="tooltip" title="" data-original-title="谨慎使用"><span class="glyphicon glyphicon-thumbs-down pull-left"></span> 踩</a>
<?php if ($model->is_topic) : ?>
    <a href="#" class="topic-fav" data-toggle="tooltip" data-placement="right" rel="tooltip" title="" data-original-title="关注并收藏"><span class="glyphicon glyphicon-star-empty"></span> 收藏</a>
<?php endif ?>
</div>
    <div class="topic-main">
        <div class="topic-content"><?= Markdown::process($model->content, 'gfm') ?></div>
        <div class="topic-author">
            <table>
                <tbody>
                    <tr>
                        <td rowspan="2">
                            <?= Html::a(Html::img($model->author->getAvatarUrl(), ['class' => 'avatar-sm']), ['topic/view', 'id' => $model->id], [
                                'title' => Html::encode($model->author->username),
                            ]) ?>
                        </td>
                        <td>
                            <h5><?= Html::a(Html::encode($model->author->username), ['topic/view', 'id' => $model->id]) ?></h5>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?= date('Y-m-d H:i:s', $model->updated_at) ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php if ($model->is_topic): ?>
    <h4> <?= $model->comment_count ?>个评论 </h4>
<?php endif ?>