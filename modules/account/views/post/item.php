<?php

use app\models\Status;
use yii\bootstrap5\Html;
?>
<div style="width: 18rem;" class="card">
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
    <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap mt-3">
      <?= Html::a('Перейти', ['view', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

      <div class="d-flex gap-2">
        <div>👍🏼<span class='count-action px-1'><?= count($model->likes) ?></span></div>
        <div>👎🏼<span class='count-action px-1'><?= count($model->dislikes) ?></span></div>
      </div>

      <?= $model->status_id == Status::getStatusId('Редактирование') ?
        Html::a('Отправить на модерацию', ['moderate', 'id' => $model->id], ['class' => 'btn btn-success my-auto']) : ''
      ?>

      <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-warning my-auto']) ?>
      <?= count($model->comment) == 0 ? Html::a('Удалить', ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger my-auto',
        'data' => [
          'confirm' => 'Вы уверены что хотите удалить элемент?',
          'method' => 'post'
        ]
      ]) : '' ?>
    </div>

  </div>
</div>