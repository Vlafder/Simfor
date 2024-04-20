<?php

use yii\db\Migration;

/**
 * Class m240416_181555_articles
 */
class m240416_181555_articles extends Migration
{
    public function up()
    {
        $this->createTable('articles', [
            'art_id'  => $this->primaryKey(), 
            'title'   => $this->string(100),
            'text'    => $this->string(2000),

            'user_id' => $this->integer(),

            'date'    => $this->date("d-M-Y H:i"),
            'likes'   => $this->integer(),
            'views'   => $this->integer()
        ]);
    }

    public function down()
    {
        echo "m240416_174524_articles cannot be reverted.\n";

        return false;
    }
}
