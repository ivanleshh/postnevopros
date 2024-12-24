<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Theme $model */

$this->title = 'Обновить тему: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Темы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="theme-update">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= Html::a('Назад', ['index'], ['class' => 'btn btn-secondary']) ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
