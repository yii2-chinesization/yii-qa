<?php

namespace app\modules\forum\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use app\components\Controller;
use app\modules\forum\models\Forum;
use app\modules\forum\models\ForumSearch;
use app\modules\forum\models\TopicSearch;

/**
 * DefaultController implements the CRUD actions for Forum model.
 */
class DefaultController extends Controller
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
        ];
    }

    /**
     * 版块列表
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ForumSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 版块帖子列表
     * @param $id
     * @return string
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $topicDataProvider = (new TopicSearch())->search(Yii::$app->request->queryParams, $model->getTopics()->active());
        $topicDataProvider->getSort()->attributes += [ // 增加(热门, 未评论)排序方式
            'hotest' => [
                'asc' => [
                    'comment_count' => SORT_DESC,
                    'created_at' => SORT_DESC
                ],
                'desc' => [
                    'comment_count' => SORT_DESC,
                    'created_at' => SORT_DESC
                ]
            ],
            'uncommented' => [
                'asc' => [
                    'comment_count' => SORT_ASC,
                    'created_at' => SORT_DESC
                ],
                'desc' => [
                    'comment_count' => SORT_ASC,
                    'created_at' => SORT_DESC
                ]
            ]
        ];
        return $this->render('view', [
            'model' => $model,
            'sortArray' => ['hotest', 'uncommented'],
            'topicDataProvider' => $topicDataProvider
        ]);
    }

    /**
     * 发布帖子
     * @param $id
     */
    public function actionPost($id)
    {
        $model = $this->findModel($id);
        return $this->render('post');
    }

    /**
     * Creates a new Forum model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Forum();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Forum model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Forum model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Forum model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Forum the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Forum::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
