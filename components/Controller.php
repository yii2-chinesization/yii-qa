<?php
namespace app\components;

use Yii;
use yii\web\Response;

class Controller extends \yii\web\Controller
{
    /**
     * 显示flash信息
     * @param $message 信息显示内容
     * @param string $type 信息显示类型, ['info', 'success', 'error', 'warning']
     * @param null $url 跳转地址
     * @return Response
     */
    public function flash($message, $type = 'info', $url = null)
    {
        Yii::$app->getSession()->setFlash($type, $message);
        if ($url !== null) {
            Yii::$app->end(0, $this->redirect($url));
        }
    }

    /**
     * @param $message 信息显示内容
     * @param string $type 信息显示类型, ['info', 'success', 'error', 'warning']
     * @param null $url 跳转地址
     * @param null $resultType 信息显示格式
     * @return array|string
     */
    public function message($message, $type = 'info', $url = null, $resultType = null)
    {
        if ($resultType === null) {
            $resultType = Yii::$app->getRequest()->getIsAjax() ? 'json' : 'html';
        }
        if ($type === null) {
            $data = $message;
        } else {
            $data = [
                'type' => $type,
                'message' => $message
            ];
        }
        if ($resultType === 'json') {
            Yii::$app->getResponse()->format = Response::FORMAT_JSON;
            return $data;
        } elseif ($resultType === 'html') {
            return $this->render('/common/message', $data);
        }
    }

    public $ajaxLayout = '/ajaxMain';
    public function findLayoutFile($view)
    {
        if (($this->layout === null) && ($this->ajaxLayout !== false) && Yii::$app->getRequest()->getIsAjax()) {
            $this->layout = $this->ajaxLayout;
        }
        return parent::findLayoutFile($view);
    }
}