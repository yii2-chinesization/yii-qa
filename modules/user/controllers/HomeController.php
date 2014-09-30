<?php

namespace app\modules\user\controllers;

use Yii;
use yii\filters\AccessControl;
use app\components\Controller;
use app\modules\user\models\User;

class HomeController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                    ],
                ],
            ],
        ];
    }

    public function actionIndex($id)
    {
        return $this->render('index', [
            'model' => $this->findModel($id)
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Yii::$app->user->id == $id ? Yii::$app->user->identity : User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
