<?php
namespace app\modules\admin\controllers;

use yii\data\ActiveDataProvider;
use app\modules\user\models\User;
use app\modules\admin\components\Controller;

class UserController extends Controller
{
    public function actionIndex()
    {
        $userModel = new User;
        return $this->render('index', [
            'userDataProvider' => new ActiveDataProvider([
                    'query' => User::find()
                ])
        ]);
    }
}