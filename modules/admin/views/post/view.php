<?php

use app\models\Status;
use yii\bootstrap5\LinkPager;
use yii\bootstrap5\Modal;
use yii\helpers\Html;
use yii\web\JqueryAsset;
use yii\widgets\DetailView;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\Post $model */

$this->title = 'Пост: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет администратора', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="post-view">

  <h3><?= Html::encode($this->title) ?></h3>

  <div class="control-btn d-flex my-3 gap-3">
    <?=
    Html::a('Назад', ['index'], ['class' => 'btn btn-secondary'])
    ?>
    <?=
    Html::a('Подробнее', '', ['class' => 'btn btn-primary btn-info-modal'])
    ?>
    <?= $model->status_id == Status::getStatusId('Редактирование') ?
      Html::a('Одобрить', ['apply', 'id' => $model->id], [
        'class' => 'btn btn-success',
        'data' => [
          'confirm' => 'Подтвердите своё действие',
          'method' => 'post',
        ],
      ]) : ''
    ?>
    <?= $model->status_id == Status::getStatusId('Редактирование') ?
      Html::a('Запретить', ['cancel', 'id' => $model->id], [
        'class' => 'btn btn-warning',
        'data' => [
          'confirm' => 'Подтвердите своё действие',
          'method' => 'post',
        ],
      ]) : ''
    ?>
    <?=
    Html::a('Удалить', ['delete', 'id' => $model->id], [
      'class' => 'btn btn-danger',
      'data' => [
        'confirm' => 'Подтвердите своё действие',
        'method' => 'post',
      ],
    ])
    ?>
  </div>


  <div class="post d-flex gap-4 mt-4">
    <div class="post-img w-50"><?= Html::img('/img/' . Html::encode($model->photo), ['class' => 'w-100 shadow-dark rounded-5', 'alt' => 'post']) ?></div>
    <div class="w-50 d-flex flex-column">
      <div class="d-flex justify-content-between">
        <h5>Автор: <?= Html::encode($model->user->login) ?></h5>
        <div class="d-flex flex-column align-items-end">
          <span><?= Yii::$app->formatter->asDate($model->created_at, 'php:d.m.Y') ?></span>
          <span><?= Yii::$app->formatter->asDate($model->created_at, 'php:H:i') ?></span>
        </div>
      </div>
      <span class="mb-3">Тема: <?= Html::encode($model->theme->title ?? $model->other_theme) ?></span>
      <p style="word-break: break-word;"><?= Html::encode($model->text) ?></p>
      <span class="align-self-end">Комментарии:</span>
      <?php Pjax::begin(); ?>

      <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{summary}<div class='my-4'>{pager}</div><div class='d-flex mt-3 flex-column gap-4 my-3'>{items}</div>",
        'itemOptions' => ['class' => 'item mx-3'],
        'itemView' => 'comment',
        'pager' => [
          'class' => LinkPager::class,
        ]
      ]) ?>

      <?php Pjax::end(); ?>
    </div>
  </div>

</div>

<?php
  Modal::begin([
    'id' => 'info-modal',
    'title' => 'Подробная информация',
    'size' => 'modal-lg',
  ]);

  echo $this->render('info-modal', compact('model'));

  Modal::end();

  $this->registerJsFile('/js/info-modal.js', ['depends' => JqueryAsset::class]);
?>