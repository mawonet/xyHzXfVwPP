<?php

/** @var yii\web\View $this */
/** @var Exception $exception */

use yii\helpers\Html;
?>
<div class="site-error">
    <?= Yii::$app->session->setFlash('error', 'У вас невалидная ссылка. Проверьте правильность или скопируйте из письма. Пост мог быть удален.'); ?>
</div>
