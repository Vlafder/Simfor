<?php

use yii\db\Migration;

/**
 * Class m240416_201718_comments
 */
class m240416_201718_comments extends Migration
{
    public function up()
    {
        $this->createTable('comments', [
            'id'      => $this->primaryKey(),
            'art_id'  => $this->integer(), 
            'text'    => $this->string(),

            'user_id' => $this->integer(),

            'date'    => $this->date("d-M-Y H:i")
        ]);
    }

    public function down()
    {
        echo "m240416_201718_comments cannot be reverted.\n";

        return false;
    }
}
