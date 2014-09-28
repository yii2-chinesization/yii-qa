<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Tag;
use app\assets\PageDownAsset;
use app\assets\SelectizeAsset;

PageDownAsset::register($this);
SelectizeAsset::register($this);
?>
<div class="forum-topic-form">
    <?php $form = ActiveForm::begin([
        'fieldConfig' => [
            'template' => "{input}\n{hint}\n{error}"
        ]
    ]); ?>
    <?= $form->errorSummary($model, [
        'class' => 'alert alert-danger'
    ]) ?>
    <?= $form->field($model, 'subject')->textInput([
        'class' => 'form-control input-lg',
        'placeholder' => '话题'
    ]) ?>
    <div class="form-group">
        <?= Html::textInput('tags', '', [
            'id' => 'topicTags',
            'placeholder' => '请点击选择标签',
        ]) ?>
    </div>
    <div class="wmd-panel">
        <div id="wmd-button-bar"></div>
        <?= $form->field($model, 'content', [
            'selectors' => [
                'input' => '#wmd-input'
            ],
        ])->textarea([
                'id' => 'wmd-input',
                'class' => 'form-control input-lg wmd-input',
                'placeholder' => '内容',
                'rows' => 10
            ]) ?>
    </div>
    <div class="form-group text-right">
        <?= Html::submitButton($model->isNewRecord ? '我要发布' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success btn-lg' : 'btn btn-primary btn-lg']) ?>
    </div>
    <div id="wmd-preview" class="wmd-panel wmd-preview"></div>
    <?php ActiveForm::end(); ?>
</div>
<?php
$tagSearchApiUrl = Url::to(['/tag/index', 'name' => '{name}', 'do' => 'search']);
$tagCreateApiUrl = Url::to(['/tag/create']);
$script = <<<EOF
    var topicConverter = Markdown.getSanitizingConverter();
        topicEditor = new Markdown.Editor(topicConverter);
    topicEditor.run();
    $('#topicTags').selectize({
        valueField: 'id',
        labelField: 'name',
        searchField: 'name',
        plugins: ['remove_button'],
        maxItems: 5,
        persist: false,
        create: true,
        createFilter: function(query) {
            var _return = true;
            if (query) {
                var _this = this;
                $.each(_this.options, function(n, item) {
                    var a = item[_this.settings.searchField];
                    if (_return != false && item[_this.settings.searchField] == query) {
                        _return = false;
                    }
                });
            }
            return _return;
        },
        render: {
            option: function(item, escape) {
                return '<div>' +
                    (item.icon ? '<img srt="' + item.icon + '"/>' : '') +
                    '<strong>' + escape(item.name) + '</strong>' +
                '</div>';
            }
        },
        load: function(query, callback) {
            query = $.trim(query);
            if (!query.length) return callback();
            $.ajax({
                url: ('{$tagSearchApiUrl}').replace(encodeURIComponent('{name}'), encodeURIComponent(query)),
                type: 'GET',
                error: function() {
                    callback();
                },
                success: function(res) {
                    res.type == 'success' ? callback(res.message) : callback();
                }
            });
        },
        onItemAdd: function (value, item) {
            var _this = this;
            $.ajax({
                url: ('{$tagCreateApiUrl}'),
                type: 'POST',
                data: {
                    Tag: {
                        name: value
                    }
                },
                error: function() {
                },
                success: function(res) {
                    if (res.type != 'success') {
                        alert(res.message);
                        if (res.type == 'error') {
                            _this.removeOption(value);
                        }
                    }
                }
            });

        }
    });
EOF;
$this->registerJs($script);