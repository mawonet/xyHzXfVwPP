<?php

use yii\db\Migration;

class m251019_075426_create_author_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%author}}', [
            'id'    => $this->primaryKey(),
            'name'  => $this->string()->notNull(),
            'email' => $this->string()->notNull()->unique(),
            'ip'    => $this->string()
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%author}}');
    }
}
