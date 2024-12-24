<?php

use app\models\Status;
use yii\bootstrap5\Html;
?>
<div class="card" style="width: 18rem;">
  <?= Html::a('<img class="card-img-top" src="/img/' . Html::encode($model->photo) . '" alt="post">', ['view', 'id' => $model->id]) ?>
  <span class="position-absolute top-0 end-0 px-2 py-1 rounded-bottom
    <?= Status::getStatusId('Запрещён') == $model->status_id ?
      'bg-danger text-light' : (Status::getStatusId('Одобрен') == $model->status_id ? 'bg-success text-light' : 'bg-warning') ?>
    "><?= Html::encode($model->status->title) ?>
  </span>
  <div class="card-body">
    <div class="d-flex justify-content-between">
      <?= Html::a('<h5 class="card-title">' . Html::encode($model->title) . '</h5>', ['view', 'id' => $model->id], ['class' => 'text-decoration-none link-dark']) ?>

      <h6 class="card-subtitle mb-2 text-body-secondary"><?= Html::encode($model->user->login) ?></h6>
    </div>
    <h6 class="card-subtitle mb-2 text-body-secondary"><?= Html::encode($model->preview) ?></h6>
    <div class="d-flex gap-3">
      <span><?= Html::encode(Yii::$app->formatter->asDatetime($model->created_at, 'php:d.m.Y')) ?></span>
      <span><?= Html::encode(Yii::$app->formatter->asDatetime($model->created_at, 'php:H:i')) ?></span>
    </div>
    <div class="d-flex flex-wrap gap-3 mt-3">
      <?= Html::a('Перейти', ['view', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
      <?=
      Html::a('Удалить', ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Подтвердите своё действие',
            'method' => 'post',
        ],
      ])
      ?>
      <? if ($model->status_id == Status::getStatusId('Модерация')) : ?>
        <?= Html::a('Одобрить', ['apply', 'id' => $model->id], [
          'class' => 'btn btn-success',
          'data' => [
            'confirm' => 'Подтвердите своё действие',
            'method' => 'post',
        ],
        ]) ?>
        <?= Html::a('Запретить', ['cancel-modal', 'id' => $model->id], [
          'class' => 'btn btn-warning btn-cancel-modal
        ']) ?>
      <? endif; ?>
    </div>
  </div>
</div>