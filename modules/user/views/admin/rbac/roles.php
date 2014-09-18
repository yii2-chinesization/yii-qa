<?php
use yii\helpers\Html;
use app\modules\admin\widgets\GridView;

$this->title = '角色列表';
$this->params['breadcrumbs'] = [
    [
        'url' => ['/admin/rbac'],
        'label' => '角色与权限'
    ],
    $this->title
];
?>
<div class="box">
    <div class="box-body">
        <?=
        GridView::widget([
            'dataProvider' => $rolesProvider,
            'button' => Html::a('添加角色', ['add-role'], ['class' => 'btn btn-primary pull-right']),
            'columns' => [
                [
                    'attribute' => 'name',
                    'label' => $authItemForm->getAttributeLabel('name'),
                    'format' => 'html',
                    'value' => function ($data) {
                            return Html::a($data->name, ['update-role', 'name' => $data->name]);
                        }
                ],
                [
                    'attribute' => 'description',
                    'label' => $authItemForm->getAttributeLabel('description'),
                ],
                [
                    'attribute' => 'ruleName',
                    'label' => $authItemForm->getAttributeLabel('ruleName'),
                ],
                [
                    'attribute' => 'data',
                    'label' => $authItemForm->getAttributeLabel('data'),
                ],
                [
                    'attribute' => 'createdAt',
                    'label' => $authItemForm->getAttributeLabel('createdAt'),
                    'format' => ['date', 'Y-m-d H:i:s'],
                    'options' => [
                        'width' => 140
                    ]
                ],
                [
                    'attribute' => 'updatedAt',
                    'label' => $authItemForm->getAttributeLabel('updatedAt'),
                    'format' => ['date', 'Y-m-d H:i:s'],
                    'options' => [
                        'width' => 140
                    ]
                ],
            ]
        ]) ?>
    </div>
</div>