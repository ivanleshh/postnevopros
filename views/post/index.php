<?php

use app\models\Post;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\web\JqueryAsset;
use yii\widgets\LinkPager;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\PostSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Страница с постами';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h3><?= Html::encode($this->title) ?></h3>

    <div class="d-flex justify-content-between align-items-center gap-3">
        <div class="formgroup">Сортировка
            <div class="d-flex gap-3 flex-wrap">
                <?= $dataProvider->sort->link('title', ['class' => 'text-decoration-none']) ?>
                <?= $dataProvider->sort->link('created_at', ['class' => 'text-decoration-none']) ?>
                <?= $dataProvider->sort->link('user_id', ['class' => 'text-decoration-none']) ?>
                <?= Html::a('сбросить', '/post', ['class' => 'text-decoration-none']) ?>
            </div>
        </div>
        <div>
            <?= $this->render('_search', [
                'model' => $searchModel,
                'themes' => $themes,
            ]); ?>
        </div>
    </div>

    <?php Pjax::begin([
        'id' => 'posts-pjax',
        'enablePushState' => false,
        'timeout' => 5000,
    ]); ?>

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

<?= $this->registerJsFile('/js/reaction.js', ['depends' => JqueryAsset::class]) ?>
