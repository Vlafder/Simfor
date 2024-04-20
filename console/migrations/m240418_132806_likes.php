<?php

use yii\db\Migration;

/**
 * Class m240418_132806_likes
 */
class m240418_132806_likes extends Migration
{
    public function up()
    {
        $this->createTable('likes', [
            'id'      => $this->primaryKey(),
            'art_id'  => $this->integer(), 
            'user_id' => $this->integer(),
            'state'   => $this->boolean()
        ]);
    }

    public function down()
    {
        echo "m240418_132806_likes cannot be reverted.\n";

        return false;
    }
}
