<?php

namespace app\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use app\models\Tag;
use app\models\TagSearch;
use app\components\Controller;

/**
 * TagController implements the CRUD actions for Tag model.
 */
class TagController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    // 默认只能Get方式查看标签列表, 和标签
                    [
                        'allow' => true,
                        'actions' => ['index', 'view'],
                        'verbs' => ['GET'],
                    ],
                    // 登录用户才能提交标题
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['@'],
                    ]
                ]
            ]
        ];
    }

    /**
     * 标签列表, 和标签关键字检索API
     * @return mixed
     */
    public function actionIndex()
    {
        $request = Yii::$app->request;
        $queryParams = $request->queryParams;
        $searchModel = new TagSearch();
        if (isset($queryParams['do'])) {
            if ($queryParams['do'] == 'search' && isset($queryParams['name'])) { //标签 关键字 检索
                $queryParams[$searchModel->formName()] = [
                    'name' => $queryParams['name']
                ];
            } else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }
        $dataProvider = $searchModel->search($queryParams);
        $dataProvider->query->active();
        if ($request->getIsAjax()) { //ajax
            return $this->message(ArrayHelper::getColumn($dataProvider->getModels(), function($model){
                return $model->getAttributes(['id', 'name', 'description']);
            }), 'success');
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tag model.
     * @param string $name
     * @return mixed
     */
    public function actionView($name)
    {
        return $this->render('view', [
            'model' => $this->findModel($name),
        ]);
    }

    /**
     * Creates a new Tag model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tag();

        if ($model->load(Yii::$app->request->post())) {
            if ($result = $model->save()) {
                $model->setActive();
                return $this->message('标签创建成功', 'success', ['view', 'id' => $model->id]);
            }
            return $this->message(array_values($model->getFirstErrors())[0], 'error');
        } else {
//            return $this->render('create', [
//                'model' => $model,
//            ]);
        }
    }

    /**
     * Updates an existing Tag model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param $string $name
     * @return mixed
     */
//    public function actionUpdate($name)
//    {
//        $model = $this->findModel($name);
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('update', [
//                'model' => $model,
//            ]);
//        }
//    }

    /**
     * Deletes an existing Tag model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param $string $name
     * @return mixed
     */
//    public function actionDelete($name)
//    {
//        $this->findModel($name)->delete();
//
//        return $this->redirect(['index']);
//    }

    /**
     * Finds the Tag model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param $string $name
     * @return Tag the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($name)
    {
        if (($model = Tag::find()->where(['name' => $name])->active()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
