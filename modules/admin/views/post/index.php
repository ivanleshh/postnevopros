<?php

use app\models\Post;
use yii\bootstrap5\Alert;
use yii\bootstrap5\LinkPager;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\web\JqueryAsset;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\modules\admin\models\PostSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Личный кабинет администратора';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h3><?= Html::encode($this->title) ?></h3>

    <?php if (Yii::$app->session->hasFlash('post-cancel')) {
        Yii::$app->session->setFlash('info', Yii::$app->session->getFlash('post-cancel'));
        Yii::$app->session->removeFlash('post-cancel');
        echo Alert::widget();
    }
    ?>

    <?= Html::a('Список пользователей', ['/panel-admin/user'], ['class' => 'btn btn-info my-2']) ?>

    <?php Pjax::begin([
        'id' => 'admin-posts-pjax',
        'enablePushState' => false,
        'timeout' => 5000,
    ]); ?>

    <div class="d-flex justify-content-between align-items-center">
        <div class="formgroup">Сортировка
            <div class="d-flex gap-3 flex-wrap">
                <?= $dataProvider->sort->link('title', ['class' => 'text-decoration-none']) ?>
                <?= $dataProvider->sort->link('created_at', ['class' => 'text-decoration-none']) ?>
                <?= $dataProvider->sort->link('user_id', ['class' => 'text-decoration-none']) ?>
                <?= Html::a('сбросить', '/panel-admin', ['class' => 'text-decoration-none']) ?>
            </div>
        </div>
        <div>
            <?= $this->render('_search', [
                'model' => $searchModel,
                'statuses' => $statuses,
            ]); ?>
        </div>
    </div>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'layout' => '{summary}{pager}<div class="d-flex mt-3 flex-wrap gap-4">{items}</div>',
        'itemOptions' => ['class' => 'item'],
        'itemView' => 'item',
        'pager' => [
            'class' => LinkPager::class,
        ]
    ]) ?>

    <?php Pjax::end(); ?>

</div>

<?php
    if ($dataProvider->count) {
        Modal::begin([
            'id' => 'cancel-modal',
            'title' => 'Запретить пост',
            'size' => 'modal-lg', // modal-xl modal-sm размеры modal
        ]);

        echo $this->render('_form-modal', compact('model_cancel'));

        Modal::end();

        $this->registerJsFile('/js/cancel-modal.js', ['depends' => JqueryAsset::class]);
    }
?>