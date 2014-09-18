<?php
namespace app\widgets;

use Yii;
use yii\base\Widget;

/**
 * Bootstrap Modal 的ajax layout渲染
 * @package app\widgets
 */
class AjaxModal extends Widget
{
    public $header = null;
    public $footer = false;

    public function init()
    {
        if (!Yii::$app->getRequest()->getIsAjax()) return;
        ob_start();
        ob_implicit_flush(false);
    }

    public function run()
    {
        if (!Yii::$app->getRequest()->getIsAjax()) return;
        return $this->render('ajaxModal', [
            'header' => $this->header,
            'content' => ob_get_clean(),
            'footer' => $this->footer
        ]);
    }
}
