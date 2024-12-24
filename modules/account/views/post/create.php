<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Post $model */

$this->title = 'Создание поста';
$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет пользователя (автора)', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= Html::a('Назад', ['index'], ['class' => 'btn btn-secondary my-2']) ?>

    <?= $this->render('_form', [
        'model' => $model,
        'themes' => $themes,
    ]) ?>

</div>
