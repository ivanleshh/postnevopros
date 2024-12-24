<?php

use app\models\User;
use app\widgets\Alert;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\web\JqueryAsset;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\modules\admin\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Список пользователей';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h3 class="mb-3"><?= Html::encode($this->title) ?></h3>

    <?php if (Yii::$app->session->hasFlash('user-block')) {
        Yii::$app->session->setFlash('info', Yii::$app->session->getFlash('user-block'));
        Yii::$app->session->removeFlash('user-block');
        echo Alert::widget();
    }
    ?>

    <?php Pjax::begin([
            'id' => 'user-block-pjax',
            'enablePushState' => false,
            'timeout' => 5000,
        ]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'id',
                'headerOptions' => [
                    'width' => 75,
                ]
            ],
            [
                'attribute' => 'login',
            ],
            [
                'label' => 'ФИО',
                'value' => fn($model) => $model->fio,
            ],
            'email',
            'phone',
            [
                'attribute' => 'created_at',
                'value' => fn($model) => Yii::$app->formatter->asDate($model->created_at, 'php:d.m.Y')
            ],
            [
                'attribute' => 'is_block',
                'value' => fn($model) => (bool)$model->is_block ? 'да' : 'нет',
            ],
            [
                'attribute' => 'expire_block',
                'value' => fn($model) => $model->expire_block ? Yii::$app->formatter->asDatetime($model->expire_block, 'php:H:i d.m.Y') : '-',
            ],
            [
                'label' => 'Действия',
                'format' => 'raw',
                'value' => function ($model) {
                    $btn_block = '';
                    if ($model->is_block == 0) {
                        $btn_block = Html::a('Заблокировать', ['block', 'id' => $model->id], ['class' => 'btn btn-danger btn-block-modal']);
                    }
                    return $btn_block;
                },
                'visible' => fn($model) => (bool)$model->is_block,
            ]
        ],
    ]); ?>

    <?php Pjax::end() ?>

</div>

<?php
    if ($dataProvider->count) {
        Modal::begin([
            'id' => 'block-modal',
            'title' => 'Блокировка пользователя',
        ]);

        echo $this->render('_form', compact('model_block'));

        Modal::end();

        $this->registerJsFile('/js/block-modal.js', ['depends' => JqueryAsset::class]);
    }
?>