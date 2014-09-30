<?php

namespace app\modules\forum\controllers;


use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use app\components\Controller;
use app\modules\forum\models\Topic;
use app\modules\forum\models\Comment;
use app\modules\forum\models\CommentSearch;

/**
 * TopicController implements the CRUD actions for Topic model.
 */
class TopicController extends Controller
{
    public $defaultAction = 'view';

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
                     // 默认只能Get方式访问
                     [
                         'allow' => true,
                         'actions' => ['view'],
                         'verbs' => ['GET'],
                     ],
                     // 登录用户才能提交评论或其他内容
                     [
                         'allow' => true,
                         'actions' => ['view'],
                         'verbs' => ['POST'],
                         'roles' => ['@'],
                     ],
                     // 登录用户才能使用API操作(赞,踩,收藏)
                     [
                         'allow' => true,
                         'actions' => ['api', 'test'],
                         'roles' => ['@']
                     ],
                 ]
            ]
        ];
    }

    /**
     * Displays a single Topic model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id, 'topic', function ($model) {
            $model->active();
        });
        $request = Yii::$app->request;
        $commentDataProvider = (new CommentSearch())->search($request->queryParams, $model->getComments());
        $commentDataProvider->query->with(['hate', 'like', 'favorite', 'author', 'author.avatar'])->active();
        return $this->render('view', [
            'model' => $model,
            'comment' => $this->newComment($model),
            'commentDataProvider' => $commentDataProvider
        ]);
    }

    /**
     * 收藏, 赞, 踩, 标签 接口
     * @param $id
     */
    public function actionApi()
    {
        $request = Yii::$app->request;
        $model = $this->findModel($request->post('id'), $request->post('type'), function ($model) {
            $model->active();
        });
        $opeartions = ['favorite', 'like', 'hate'];
        if (!in_array($do = $request->post('do'), $opeartions)) {
            return $this->message('错误的操作', 'error');
        }
        $result = $model->{'toggle' . $do}(Yii::$app->user->getId());
        if ($result !== true) {
            return $this->message($result === false ? '操作失败' : $result, 'error');
        }
        return $this->message('操作成功', 'success');
    }

    public function actionTest($id)
    {
        $model = $this->findModel($id);
        $model->toggleLike(Yii::$app->user->getId());
        return $this->render('test', [
            'model' => $model
        ]);
    }

    /**
     * Finds the Topic model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Topic the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $type = 'topic', \Closure $func = null)
    {
        if ($id) {
            $model = $type == 'topic' ? Topic::find() : Comment::find();
            $model->andWhere(['id' => $id])->active();
            $func !== null && $func($model);
            $model = $model->one();
            if ($model !== null) {
                return $model;
            }
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * 创建新评论
     * @param $topic
     * @return Comment
     */
    protected function newComment(Topic $topic)
    {
        $model = new Comment;
        if ($model->load(Yii::$app->request->post())) {
            $model->author_id = Yii::$app->user->id;
            if ($topic->addComment($model, true)) {
                $this->flash('发表评论成功!', 'success');
                Yii::$app->end(0, $this->refresh());
            }
        }
        return $model;
    }
}
