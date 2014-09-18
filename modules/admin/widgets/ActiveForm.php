<?php
namespace app\modules\admin\widgets;

/**
 * 后台表单通用显示格式
 * @package app\modules\admin\widgets
 */
class ActiveForm extends \yii\widgets\ActiveForm
{
    public $fieldConfig = [
        'labelOptions' => [
            'class' => 'col-sm-3 control-label'
        ],
        'template' => "<div class=\"col-sm-6\">{label}\n<div class=\"col-sm-9\">{input}\n{error}</div></div>\n<div class=\"col-sm-6\">{hint}</div>"
    ];
    public $options = [
        'class' => 'form-horizontal'
    ];

    /**
     * 表单动作模板
     * @var string
     */
    public $actionTemplate = "<div class=\"form-action clearfix\"><div class=\"col-sm-6\"><div class=\"col-sm-offset-3 col-sm-9\">{action}</div></div></div>";

    /**
     * 表单动作渲染
     * @param $action
     * @return string
     */
    public function action($action)
    {
        return strtr($this->actionTemplate, [
            '{action}' => $action
        ]);
    }
}