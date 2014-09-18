<?php

namespace app\modules\user\controllers;

use Yii;
use yii\filters\AccessControl;
use app\components\Controller;
use app\modules\user\models\LoginForm;
use app\modules\user\models\RegisterForm;

class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'register', 'auth'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'successCallback'],
            ],
        ];
    }

    public function successCallback($client)
    {
        $attributes = $client->getUserAttributes();
        // user login or signup comes here
        var_dump($client);
        var_dump($attributes);
        exit;
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $loginForm = new LoginForm();
        if ($loginForm->load(Yii::$app->request->post()) && $loginForm->login()) {
            return $this->goBack();
        } else {
            $method = Yii::$app->getRequest()->isAjax ? 'renderAjax' : 'render';
            return $this->$method('login', [
                'loginForm' => $loginForm,
            ]);
        }
    }

    public function actionRegister()
    {
        $registerForm = new RegisterForm();
        if ($registerForm->load(Yii::$app->request->post())) {
            $user = $registerForm->register();
            if ($user) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }
        $method = Yii::$app->getRequest()->isAjax ? 'renderAjax' : 'render';
        return $this->$method('login', [
            'registerForm' => $registerForm,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->getUser()->logout();

        return $this->goHome();
    }
}
