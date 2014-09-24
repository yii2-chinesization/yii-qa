<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\PageDownAsset;

PageDownAsset::register($this);
$this->registerJs("
    var topicConverter = Markdown.getSanitizingConverter();
        topicEditor = new Markdown.Editor(topicConverter);
    topicEditor.run();
");
?>

<div class="forum-topic-form">
    <?php $form = ActiveForm::begin([
        'fieldConfig' => [
            'template' => "{input}\n{hint}\n{error}"
        ]
    ]); ?>
    <?=
    $form->errorSummary($model, [
        'class' => 'alert alert-danger'
    ]) ?>
    <?=
    $form->field($model, 'subject')->textInput([
        'class' => 'form-control input-lg',
        'placeholder' => '话题'
    ]) ?>
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
