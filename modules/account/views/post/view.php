<?php

use app\models\Status;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\Post $model */

$this->title = 'Пост: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет пользователя (автора)', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="post-view">

    <h3><?= Html::encode($this->title) ?></h3>

    <div class="control-btn my-3 d-flex gap-3">
        <?=
        Html::a('Назад', ['index'], ['class' => 'btn btn-secondary'])
        ?>
        <?= $model->status_id == Status::getStatusId('Редактирование') ?
            Html::a('Отправить на модерацию', ['moderate', 'id' => $model->id], ['class' => 'btn btn-success my-auto'])
            : ''
        ?>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-warning my-auto']) ?>
        <?= count($model->comment) == 0 ?
            Html::a('Удалить', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger my-auto',
                'data' => [
                    'confirm' => 'Вы уверены что хотите удалить элемент?',
                    'method' => 'post'
                ]
            ]) : '' ?>
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

            <div class="d-flex justify-content-between gap-3 mb-3">
                <div class="d-flex gap-2">
                    <div>👍🏼<span class='count-action px-1'><?= count($model->likes) ?></span></div>
                    <div>👎🏼<span class='count-action px-1'><?= count($model->dislikes) ?></span></div>
                </div>
                <span class="align-self-end">Комментарии:</span>
            </div>

            <?php Pjax::begin(); ?>

            <?= !Yii::$app->user->isGuest && (Yii::$app->user->id !== $model->user_id) ? $this->render('form', ['model' => $comment]) : '' ?>

            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'layout' => "{summary}{pager}<div class='comments position-relative d-flex mt-3 flex-column gap-4 my-3'>{items}</div>",
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