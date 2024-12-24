<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Theme $model */

$this->title = 'Создать тему';
$this->params['breadcrumbs'][] = ['label' => 'Темы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="theme-create">

    <h3><?= Html::encode($this->title) ?></h1>

    <?= Html::a('Назад', ['index'], ['class' => 'btn btn-secondary']) ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
