<?php
namespace app\modules\admin\components;

use yii\filters\AccessControl;

class Controller extends \app\components\Controller
{
    public $layout = '@app/modules/admin/views/layouts/main';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    public function message($message, $type = 'info', $url = null, $resultType = null)
    {
        if ($resultType !== null) {
            return $this->message($message, $type, $resultType);
        }

    }
}