<?php
/** @var yii\web\View $this */
/** @var array $posts */

use yii\widgets\ListView;
use yii\data\ActiveDataProvider;
use yii\widgets\LinkPager;
use app\models\Post;

$dataProvider = new ActiveDataProvider([
        'query' => Post::findAllWithAuthor(),
        'pagination' => [
                'pageSize' => 20,
        ],
]);

echo ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => 'post_view',
        'itemOptions' => [
        'tag' => 'li',
        'class' => 'list-group-item',
    ],
        'pager' => [
        'class' => LinkPager::class,
        'prevPageLabel' => false,
        'nextPageLabel' => false,
        'options' => [
            'class' => 'pagination custom-pagination',
        ],
        'linkOptions' => ['class' => 'page-link custom-link'],
    ],
]);

?>
