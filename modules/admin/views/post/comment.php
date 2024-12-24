<?php

use app\models\User;
use yii\bootstrap5\Html;
?>
<div class="d-flex justify-content-between border-left">
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
    <div class="comment-date d-flex align-self-start flex-column align-items-center">
        <span>
            <?= Yii::$app->formatter->asDatetime($model->created_at, 'php:H:i d.m.Y') ?>
        </span>
        <?= Html::a('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
        </svg>', ['/panel-admin/comment/delete', 'id' => $model->id], ['data' => ['confirm' => 'Вы уверены что хотите удалить элемент?', 'method' => 'post'],
        ]) ?>
    </div>
    
</div>

<?php if (!empty($model->children)): ?>
    <div class="mt-3 ms-5 d-flex flex-column gap-3">
        <?php foreach ($model->children as $child): ?>
            <?= $this->render('comment', ['model' => $child]) ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>