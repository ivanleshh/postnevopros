<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Post $model */

$this->title = 'Запретить пост: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет администратора', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Запрет';
?>
<div class="post-update">

    <h3><?= Html::encode($this->title) ?></h3>

    <?=
        Html::a('Назад', ['index'], ['class' => 'btn btn-secondary my-2'])
    ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
