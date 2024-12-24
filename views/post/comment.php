<?php

use app\models\Comment;
use app\models\User;
use yii\bootstrap5\Html;
use yii\bootstrap5\LinkPager;
use yii\web\JqueryAsset;
use yii\widgets\ListView;
use yii\widgets\Pjax;

?>
<div class="d-flex justify-content-between border-left comment">
    <div class="d-flex gap-3 align-items-center">
        <div>
            <?= (isset($model->user->avatar) ? '<img style="width: 3rem; height: 3rem" class="rounded-circle" src="/img/' . $model->user->avatar .
                '">' : '<img style="width: 3rem; height: 3rem" class="rounded-circle" src="/img/' . User::NO_PHOTO . '">') ?>
        </div>
        <div>
            <span class="fw-bold"><?= Html::encode($model->user->fio) ?></span>
            <p class="m-0"><?= Html::encode($model->text) ?></p>
        </div>

    </div>
    <div class="comment-date d-flex gap-2 flex-column align-self-start">
        <?= Yii::$app->formatter->asDatetime($model->created_at, 'php:H:i d.m.Y') ?>
        <?= ($model->post->user_id == Yii::$app->user->id && is_null($model->parent_id)) ? Html::button('Ответить', ['class' => 'btn border border-secondary p-0 btn-answer']) : '' ?>
    </div>
</div>

<?php if (is_null($model->parent_id)) : ?>
    <div class="answer-form answer-hide">
        <?php Pjax::begin(); ?>

        <?= !Yii::$app->user->isGuest && $model->post->user_id == Yii::$app->user->id ?
            $this->render('form', ['model' => new Comment(), 'parent_id' => $model->id]) : '' ?>

        <?php Pjax::end(); ?>
    </div>
<?php endif; ?>

<?php if (!empty($model->children)): ?>
    <div class="mt-3 ms-5 d-flex flex-column gap-3">
        <?php foreach ($model->children as $child): ?>
            <?= $this->render('comment', ['model' => $child]) ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?= $this->registerJsFile('/js/answer.js', ['depends' => JqueryAsset::class]) ?>