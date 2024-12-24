<?php

namespace app\modules\admin\controllers;

use app\models\Comment;
use app\models\Post;
use app\models\Status;
use app\models\Theme;
use app\modules\admin\models\CommentSearch;
use app\modules\admin\models\PostSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Post models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $model_cancel = null;
        if ($dataProvider->count) {
            $model_cancel = $this->findModel($dataProvider->models[0]->id);
            $model_cancel->scenario = Post::SCENARIO_CANCEL;
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'statuses' => Status::getStatuses('Редактирование'),
            'model_cancel' => $model_cancel,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $searchModel = new CommentSearch(['post_id' => $id]);
        $dataProvider = $searchModel->search($this->request->queryParams);
        $comment = new Comment();

        if ($this->request->isPost) {
            if ($comment->load($this->request->post())) {
                $comment->user_id = Yii::$app->user->id;
                $comment->post_id = $id;
                if ($comment->save()) {
                    return $this->redirect(['view', 'id' => $id]);
                }
            }
        }

        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'model' => $this->findModel($id),
            'comment' => $comment,
        ]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionCancel($id)
    {
        $model = $this->findModel($id);
        $model->scenario = Post::SCENARIO_CANCEL;

        if ($this->request->isPost && $model->load($this->request->post())) {
            if ($model->status_id == Status::getStatusId('Модерация')) {
                $model->status_id = Status::getStatusId('Запрещён');
                if ($model->save()) {
                    Yii::$app->session->setFlash('warning', "Статус поста № $model->id изменён на - Запрещён");
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        return $this->render('cancel', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionCancelModal($id)
    {
        $model = $this->findModel($id);
        $model->scenario = Post::SCENARIO_CANCEL;

        if ($this->request->isPost && $model->load($this->request->post())) {
            if ($model->status_id == Status::getStatusId('Модерация')) {
                $model->status_id = Status::getStatusId('Запрещён');
                if ($model->save()) {
                    Yii::$app->session->setFlash(
                        'post-cancel', 
                        "Статус поста № $model->id изменён на - Запрещён"
                    );
                    $model->cancel_reason = null;
                    return $this->render('_form-modal', [
                        'model_cancel' => $model
                    ]);
                }
            }
        }

        return $this->render('cancel', [
            'model' => $model,
        ]);
    }

    public function actionApply($id)
    {
        if ($model = $this->findModel($id)) {
            if ($model->status_id == Status::getStatusId('Модерация')) {
                $model->status_id = Status::getStatusId('Одобрен');
                $model->save();
                Yii::$app->session->setFlash('success', "Статус поста № $model->id изменён на - Одобрен");
            }
        }
        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
