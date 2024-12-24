<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\web\JqueryAsset;

/** @var yii\web\View $this */
/** @var app\models\Post $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="comment-form">

    <?php $form = ActiveForm::begin([
        'id' => 'form-comment',
    ]); ?>

    <?= Html::hiddenInput('parent_id', $parent_id ?? null) ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 2]) ?>

    <div class="form-group d-flex justify-content-end">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>