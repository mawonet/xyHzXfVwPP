<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\PostForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\captcha\Captcha;
?>

<?php $form = ActiveForm::begin(['id' => 'post_create']); ?>

<?= $form->field($model, 'name') ?>
<?= $form->field($model, 'email') ?>
<?= $form->field($model, 'content')->textarea([
        'rows' => 3
])?>
<?= $form->field($model, 'verifyCode')->widget(Captcha::class, [
    'template' => '<div class="row-cols-lg-3">{image}</div><div class="col-lg-12">{input}</div>',
]) ?>

<div class="form-group">
    <?= Html::submitButton('Отправить', ['class' => 'btn btn-success', 'name' => 'post-update-button']) ?>
</div>

<?php ActiveForm::end(); ?>
