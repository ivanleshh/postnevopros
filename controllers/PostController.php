<?php

namespace app\controllers;

use app\models\Comment;
use app\models\CommentSearch;
use app\models\Post;
use app\models\PostSearch;
use app\models\Reaction;
use app\models\Theme;
use app\models\User;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;

/**
 * CatalogController implements the CRUD actions for Post model.
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
    public function actionIndex($id = null, $like = null)
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        if (isset($like)) {
            $res = 0;
            $model = Reaction::findOne([
                'user_id' => Yii::$app->user->id,
                'post_id' => $id,
            ]);
            if (is_null($model)) {
                $model = new Reaction();
                $model->user_id = Yii::$app->user->id;
                $model->post_id = (int)$id;
            }
            if ($model->reaction == $like) {
                $model->reaction = '0';
            } else {
                $model->reaction = $like;
            }
            $model->save();

            $likes = Reaction::find()->where(['post_id' => $id, 'reaction' => '1'])->count();
            $dislikes = Reaction::find()->where(['post_id' => $id, 'reaction' => '-1'])->count();

            return $this->asJson([
                'likes' => $likes,
                'dislikes' => $dislikes,
            ]);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'themes' => Theme::getThemes(),
            'users' => User::getUsers(),
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
                    Yii::$app->session->setFlash('success', "Вы оставили комментарий под постом " . $model->post->title);
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
