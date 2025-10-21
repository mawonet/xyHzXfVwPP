<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\Post $model */
/** @var array $post */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'StoryValut';

?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
    </div>

    <div class="body-content">
        <div class="row">
            <span><b> Автор:  </b> <?= $model->author->name; ?></span><br>
            <span><b> Дата создания: </b> <?= date("d-m-Y-H-i-s", $model->created_at); ?></span>
        </div>
        <div class="row">
            <div class="col-lg-8 mb-2">
                <?php $form = ActiveForm::begin(['id' => 'post_update']); ?>

                <?= $form->field($model, 'content')->textarea([
                    'rows' => 3
                ])?>

                <div class="form-group">
                    <?= Html::submitButton('Обновить', ['class' => 'btn btn-success', 'name' => 'post-update-button']) ?>
                    <?= Html::a('На главную', ['/index.php'], ['class' => 'btn btn-primary'])?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>