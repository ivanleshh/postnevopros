<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\web\JqueryAsset;

/** @var yii\web\View $this */
/** @var app\models\Post $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin([
        'id' => 'form-post',
    ]); ?>

    <?= $form->field($model, 'title') ?>
    <?= $form->field($model, 'preview') ?>
    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'imageFile')->fileInput() ?>
    <?= $form->field($model, 'theme_id')->dropDownList($themes, ['prompt' => 'Выберите тему поста']) ?>
    <?= $form->field($model, 'check')->checkbox() ?>
    <?= $form->field($model, 'other_theme')->textInput(['disabled' => ($model->other_theme == "" ? true : false)]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?= $this->registerJsFile('/js/theme.js', ['depends' => JqueryAsset::class]) ?>
