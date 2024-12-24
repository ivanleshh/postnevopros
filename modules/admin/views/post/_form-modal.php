<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\Post $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="post-form p-2">

    <?php Pjax::begin([
        'id' => 'form-cancel-pjax',
        'enablePushState' => false,
        'timeout' => 5000,
    ]) ?>

        <?php $form = ActiveForm::begin([
            'id' => 'form-cancel',
            'options' => [
                'data-pjax' => true,
            ]
        ]); ?>

        <?= $form->field($model_cancel, 'cancel_reason')
        ->textarea(['maxlength' => true, 'rows' => 4]) ?>

        <div class="form-group d-flex gap-3">
            <?= Html::a('Назад', '', [
                'class' => 'btn btn-secondary btn-modal-close', 
                'data-pjax' => 0]) 
            ?>
            <?= Html::submitButton('Запретить', ['class' => 'btn btn-danger']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    <?php Pjax::end() ?>
</div>