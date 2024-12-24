<?php

namespace app\modules\account\controllers;

use app\models\Comment;
use app\models\Post;
use app\models\Status;
use app\models\Theme;
use app\modules\account\models\PostSearch;
use app\modules\account\models\CommentSearch;
use Codeception\Scenario;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use yii\web\UploadedFile;

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

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'themes' => Theme::getThemes(),
        ]);
    }

    /**
     * Displays a single Post model.
     * @param int $id №
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $searchModel = new CommentSearch(['post_id' => $id]);
        $dataProvider = $searchModel->search($this->request->queryParams);
        $model = new Comment();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->parent_id = Yii::$app->request->post('parent_id') ?? null;
                $model->user_id = Yii::$app->user->id;
                $model->post_id = $id;
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $id]);
                }
            }
        }

        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'model' => $this->findModel($id),
            'comment' => $model,
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Post(['scenario' => Post::SCENARIO_THEME]);

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->check) {
                    $model->scenario = Post::SCENARIO_OTHER;
                    $model->theme_id = null;
                } else {
                    $model->other_theme = null;
                }
                $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
                if (is_null($model->imageFile) || $model->upload()) {
                    $model->user_id = Yii::$app->user->id;
                    $model->status_id = Status::getStatusId('Редактирование');
                    if ($model->save(false)) {
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'themes' => Theme::getThemes(),
        ]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {
            if ($model->check) {
                $model->scenario = Post::SCENARIO_OTHER;
                $model->theme_id = null;
            } else {
                $model->other_theme = null;
            }
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if (is_null($model->imageFile) || $model->upload()) {
                $model->status_id = Status::getStatusId('Редактирование');
                if ($model->save(false)) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'themes' => Theme::getThemes(),
        ]);
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

    public function actionModerate($id) 
    {
        if ($model = $this->findModel($id)) {
            if ($model->status_id == Status::getStatusId('Редактирование')) {
                $model->status_id = Status::getStatusId('Модерация');
                $model->save();
                Yii::$app->session->setFlash('success', "Пост $model->title отправлен на модерацию");
            }
        }
        return $this->redirect(['index']);
    }
}
