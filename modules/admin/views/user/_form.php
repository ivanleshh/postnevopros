<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\web\JqueryAsset;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-form">

    <?php Pjax::begin([
        'id' => 'form-block-pjax',
        'enablePushState' => false,
        'timeout' => 5000,
    ]) ?>

    <?php $form = ActiveForm::begin([
        'id' => 'form-user',
        'options' => [
            'data-pjax' => true,
        ]
    ]); ?>

    <?= $form->field($model_block, 'check')->checkbox(['class' => 'mt-3']) ?>

    <?= $form->field($model_block, 'expire_block')->textInput([
        'disabled' => true,
        'type' => 'date',
        'min' => date('Y-m-d')
    ]) ?>

    <div class="form-group d-flex gap-3">
        <?= Html::a('Назад', '', [
            'class' => 'btn btn-secondary btn-modal-close',
            'data-pjax' => 0
        ])
        ?>
        <?= Html::submitButton('Заблокировать', ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php Pjax::end() ?>

</div>

<?= $this->registerJsFile('/js/block.js', ['depends' => JqueryAsset::class]) ?>