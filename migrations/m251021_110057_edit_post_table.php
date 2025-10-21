<?php

use yii\db\Migration;

class m251021_110057_edit_post_table extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('post', 'title');
    }

    public function safeDown()
    {
        $this->addColumn('post', 'title', $this->string());
    }

}
