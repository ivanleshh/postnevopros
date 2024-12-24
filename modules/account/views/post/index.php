<?php

use app\models\Post;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\modules\account\models\PostSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Личный кабинет пользователя (автора)';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <?= Html::a('Создать пост', ['create'], ['class' => 'btn btn-success mt-2']) ?>
    </p>

    <div class="d-flex justify-content-between align-items-center gap-3">
        <div class="d-flex gap-3 flex-wrap">
            <?= $dataProvider->sort->link('created_at', ['class' => 'text-decoration-none']) ?>
            <?= $dataProvider->sort->link('status_id', ['class' => 'text-decoration-none']) ?>
            <?= Html::a('сбросить', ['index'], ['class' => 'text-decoration-none']) ?>
        </div>
        <?= $this->render('_search', [
            'model' => $searchModel,
            'themes' => $themes,
        ]); ?>
    </div>

    <?php Pjax::begin([
        'id' => 'posts-pjax',
        'enablePushState' => false,
        'timeout' => 5000,
    ]); ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'layout' => '{summary}{pager}<div class="d-flex flex-wrap gap-4 my-3">{items}</div>',
        'itemOptions' => ['class' => 'item'],
        'itemView' => 'item',
    ]) ?>

    <?php Pjax::end(); ?>

</div>