<?php
use yii\helpers\Html;
use app\modules\admin\widgets\GridView;

$this->title = '用户管理';
$this->params['breadcrumbs'] = [
    $this->title
];

?>
<div class="box">
    <div class="box-body">
        <?= GridView::widget([
            'dataProvider' => $userDataProvider,
            'button' => Html::a('添加用户', ['/admin/user/add'], ['class' => 'btn btn-primary pull-right']),
            'columns' => [
                [
                    'attribute' => 'id',
                    'options' => [
                        'width' => 30
                    ]
                ],
                [
                    'attribute' => 'username',
                ],
                [
                    'attribute' => 'email',
                ],
                [
                    'attribute' => 'last_login_ip',
                    'options' => [
                        'width' => 100
                    ]
                ],
                [
                    'attribute' => 'status',
                    'options' => [
                        'width' => 60
                    ]
                ],
                [
                    'attribute' => 'last_visit_at',
                    'format' => ['date', 'Y-m-d H:i:s'],
                    'options' => [
                        'width' => 140
                    ]
                ],
                [
                    'attribute' => 'created_at',
                    'format' => ['date', 'Y-m-d H:i:s'],
                    'options' => [
                        'width' => 140
                    ]
                ],
                [
                    'attribute' => 'updated_at',
                    'format' => ['date', 'Y-m-d H:i:s'],
                    'options' => [
                        'width' => 140
                    ]
                ],

            ]
        ]) ?>
    </div>
</div>