<?php
namespace app\modules\admin\widgets;

/**
 * 后台通用Grid显示格式
 * @package app\modules\admin\widgets
 */
class GridView extends \yii\grid\GridView
{

    /**
     * 自定义section的内容
     * @var string
     */
    public $button;
    /**
     * - `{button}`: the button section. See [[$this->button]].
     * @inheritdoc
     */
    public $layout = "<div class=\"grid-view-header clearfix\">{pager}\n{summary}\n{button}\n</div><div class=\"grid-view-body table-responsive\">{items}</div><div class=\"grid-view-footer clearfix\">{pager}\n{summary}\n{button}\n</div>";
    /**
     * @inheritdoc
     */
    public $summaryOptions = [
        'class' => 'pull-left summary'
    ];
    /**
     * @inheritdoc
     */
    public $pager = [
        'options' => [
            'class' => 'pull-left pagination'
        ]
    ];

    /**
     * @inheritdoc
     */
    public function renderSection($name)
    {
        switch ($name) {
            case '{button}':
                return $this->button;
            default:
                return parent::renderSection($name);
        }
    }
}