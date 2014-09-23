<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\Markdown;
$isTopic = !$model->tid;
?>
<div class="<?= $isTopic ? 'topic' : 'topic-comment' ?>">
    <div class="clearfix">
        <?php if ($isTopic) : ?>
            <?php $this->title = Html::encode($model->subject) ?>
            <div class="topic-title">
                <h3><?= Html::encode($this->title) ?></h3>
            </div>
        <?php endif ?>
        <div class="topic-cell">
            <a class="topic-like <?= $model->like && $model->like->value ? 'active' : '' ?>"
               data-id="<?= $model->id ?>" data-do="like" data-type="<?= $isTopic ? 'topic' : 'comment' ?>"
               href="#">
                <span class="num"><?= $model->like_count ?></span>
                <span class="glyphicon glyphicon-thumbs-up pull-left"></span> 赞
            </a>
            <a class="topic-hate <?= $model->hate && $model->hate->value ? 'active' : '' ?>"
               data-id="<?= $model->id ?>" data-do="hate" data-type="<?= $isTopic ? 'topic' : 'comment' ?>"
               href="#" data-toggle="tooltip" data-placement="right"
               rel="tooltip" title="" data-original-title="谨慎使用"><span
                    class="glyphicon glyphicon-thumbs-down pull-left"></span> 踩</a>
            <?php if ($isTopic) : ?>
                <a class="topic-fav <?= $model->favorite && $model->favorite->value ? 'active' : '' ?>"
                   data-id="<?= $model->id ?>" data-do="favorite"
                   data-type="<?= $isTopic ? 'topic' : 'comment' ?>" href="#" data-toggle="tooltip"
                   data-placement="right"
                   rel="tooltip" title="" data-original-title="关注并收藏"><span
                        class="glyphicon glyphicon-star-empty"></span> 收藏</a>
            <?php endif ?>
        </div>
        <div class="topic-main">
            <div class="topic-content"><?= Markdown::process($model->content, 'gfm') ?></div>
            <div class="topic-author">
                <table>
                    <tbody>
                    <tr>
                        <td rowspan="2">
                            <?=
                            Html::a(Html::img($model->author->getAvatarUrl(), ['class' => 'avatar-sm']), ['topic/view', 'id' => $model->id], [
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
    <?php if ($isTopic): ?>
        <h4 class="mb0"> <?= $model->comment_count ?>个评论 </h4>
    <?php endif ?>
</div>
<?php
if ($isTopic) {
    $apiUrl = Url::to(['api']);
    $script = <<<EOF
//赞, 踩, 收藏
$(document).on('click', '[data-do]', function(e){
    var _this = $(this),
        _id = _this.data('id'),
        _do = _this.data('do'),
        _type = _this.data('type');
    if (_this.is('a')) e.preventDefault();
    $.post('{$apiUrl}', {id: _id, do: _do, type: _type}, function(result){
        if (result.type == 'success') {
            //修改记数
            var num = _this.find('.num'),
                numValue = parseInt(num.html()),
                active = _this.hasClass('active');
            _this.toggleClass('active');
            if (num.length) {
                num.html(numValue + (active ? -1 : 1));
            }
            if ($.inArray(_do, ['like', 'hate']) >= 0) {
                _this.siblings('[data-do=like],[data-do=hate]').each(function(){
                    var __this = $(this),
                        __do = __this.data('do'),
                        __id = __this.data('id');
                    if (__id == _id) { // 同一个主题或评论触发
                        __this.toggleClass('active', __do == _do);

                        var _num = __this.find('.num')
                            _numValue = parseInt(_num.html());
                        if (_num.length) {
                            _num.html(_numValue + (__do != _do ? (_numValue > 0 ? -1 : 0): 1));
                        }
                    }
                });
            }
        } else {
            alert(result.message);
        }
    });
});
EOF;
    $this->registerJs($script);
}