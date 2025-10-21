<?php

/** @var yii\web\View $this */
/** @var array $post */

use yii\bootstrap5\Button;
use yii\bootstrap5\Html;

$this->title = 'StoryValut';

?>

<h1>Вы уверены что хотите удалить?</h1>
<?= Html::a('Удалить?', ['', 'link' => $post->link], ['id' => 'remove','class' => 'btn btn-danger']) ?>
<br>
<div style="margin-top: 10px;">

<?= Html::a('На главную', ['/index.php'], ['class' => 'btn btn-primary'])?>
</div>
<?php
$this->registerJs("
$(document).ready(function() {
    $('#remove').click(function() {
        let params1 = new URLSearchParams(document.location.search);
        $.ajax({
            url: 'site/remove',
            type: 'POST',
            data: {
                link: params1.get('link')
            },
            success: function(response) {
                if (response.status === 'success') {
                    console.log('Успех:', response.result);
                    document.location.href = 'site/index';
                } else {
                    console.error('Ошибка:', response.message);
                    document.location.href = 'site/index';
                }
            },
            error: function() {
                console.error('Произошла ошибка при отправке запроса');
            }
        });
    });
});
")
?>