<?php

/** @var yii\web\View $this */
/** @var app\models\PostForm $modelPost */
/** @var array $posts */

$this->title = 'StoryValut';

?>
<div class="site-index">
    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-8 mb-2">
                <?= $this->render('post_listing',[
                        'posts' => $posts,
                ]); ?>
            </div>
            <div class="col-lg-4 mb-1">
                <?= $this->render('post_create', [
                        'model' => $modelPost,
                ]); ?>
            </div>
        </div>

    </div>
</div>
