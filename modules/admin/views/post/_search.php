<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\modules\admin\models\PostSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="post-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <div class="d-flex gap-3 align-items-end flex-wrap">
        <?= $form->field($model, 'title') ?>
        <?= $form->field($model, 'status_id')->dropDownList($statuses, ['prompt' => 'Выбрать статус']) ?>

        <div class="form-group">
            <?= Html::submitButton('Найти', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Сбросить', ['/admin'], ['class' => 'btn btn-outline-secondary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>