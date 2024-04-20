<?php

use yii\db\Migration;

/**
 * Class m240419_021731_asd
 */
class m240419_021731_asd extends Migration
{
    public function up()
    {
        $this->createTable('some', [
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
