<?php

use yii\bootstrap5\Html;
use yii\widgets\DetailView;
?>

<div class="post-detail p-2">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            [
                'attribute' => 'theme_id',
                'value' => $model->theme?->title,
                'visible' => (bool)$model->theme?->title,
            ],
            [
                'attribute' => 'other_theme',
                'value' => $model?->other_theme,
                'visible' => (bool)$model?->other_theme,
            ],
            'text:ntext',
            [
                'attribute' => 'user_id',
                'value' => $model->user->fio,
            ],
            'preview',
            [
                'attribute' => 'status_id',
                'value' => $model->status->title,
            ],
            [
                'label' => 'Имя изображению',
                'value' => $model->photo,
            ],
            [
                'attribute' => 'cancel_reason',
                'value' => $model?->cancel_reason,
                'visible' => (bool)$model?->cancel_reason,
            ],
            [
                'attribute' => 'created_at',
                'value' => Yii::$app->formatter->asDatetime($model->created_at, 'php:H:i d.m.Y'),
            ],
            [
                'attribute' => 'updated_at',
                'value' => Yii::$app->formatter->asDatetime($model->updated_at, 'php:H:i d.m.Y'),
            ],
        ],
    ]) ?>

</div>