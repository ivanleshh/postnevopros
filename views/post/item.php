<?php

use yii\bootstrap5\Html;
?>
<div class="card" style="width: 18rem;">
  <?= Html::a('<img class="card-img-top" src="/img/' . Html::encode($model->photo) . '" alt="post">', ['view', 'id' => $model->id]) ?>
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

    <div class="d-flex justify-content-between align-items-center flex-wrap">
      <?= Html::a('Перейти', ['view', 'id' => $model->id], ['class' => 'btn btn-primary my-3']) ?>
      <div class="cover d-flex gap-2">
      <?php if (!Yii::$app->user->isGuest && !Yii::$app->user->identity->isAdmin && Yii::$app->user->id !== $model->user_id) : ?>
          <?= Html::a(
            '👍🏼' . "<span class='count-likes px-1 text-primary'>" . count($model->likes) . "</span>",
            ['index', 'id' => $model->id, 'like' => 1],
            ['class' => 'text-decoration-none link-dark btn-reaction']
          ) ?>
          <?= Html::a(
            '👎🏼' . "<span class='count-dislikes px-1 text-primary'>" . count($model->dislikes) . "</span>",
            ['index', 'id' => $model->id, 'like' => -1],
            ['class' => 'text-decoration-none link-dark btn-reaction']
          ) ?>
        <?php else : ?>
          <div>👍🏼<span class='count-action px-1'><?= count($model->likes) ?></span></div>
          <div>👎🏼<span class='count-action px-1'><?= count($model->dislikes) ?></span></div>
        <?php endif; ?>
      </div>
      <?= !Yii::$app->user->isGuest && Yii::$app->user->id == $model->user_id ?
        Html::a('Редактировать', ['/account/post/update', 'id' => $model->id], ['class' => 'btn btn-warning my-auto']) : '' ?>
      <?= !Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin ?
        Html::a('Удалить', ['delete', 'id' => $model->id], [
          'class' => 'btn btn-danger my-auto',
          'data' => [
            'confirm' => 'Вы уверены что хотите удалить элемент?',
            'method' => 'post'
          ]
        ]) : '' ?>
    </div>
  </div>
</div>