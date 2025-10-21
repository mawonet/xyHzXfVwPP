<?php

use yii\helpers\Html;
use Carbon\Carbon;
use app\helpers\IpHelper;

Carbon::setLocale('ru');
\Yii::$app->language = 'ru-RU'
?>
<div>
    <div class="card card-default">
        <div class="card-body">
            <h5 class="card-title"><?= Html::encode($model->author->name) ?></h5>
            <p><?= Html::encode($model->content) ?></p>
            <p>
                <small class="text-muted">
                    <?= Carbon::createFromTimestamp($model->updated_at)->diffForHumans(); ?>
                    | <?= IpHelper::maskLastTwo($model->author->ip) ?> |
                    <?= \Yii::t('app', 'messages_post', ['n' => $model->author_posts_count]);?>
                </small>
            </p>
        </div>
    </div>
</div>