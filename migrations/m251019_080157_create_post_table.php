<?php

use yii\db\Migration;

class m251019_080157_create_post_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%post}}', [
            'id'         => $this->primaryKey(),
            'author_id'  => $this->integer(),
            'title'      => $this->string(),
            'content'    => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'is_deleted' => $this->boolean()->defaultValue(0),
            'link'       => $this->string(),
        ]);

        $this->addForeignKey('fk_post_author', 'post', 'author_id', 'author', 'id');
    }

    public function safeDown()
    {
        $this->dropTable('{{%post}}');
    }
}
