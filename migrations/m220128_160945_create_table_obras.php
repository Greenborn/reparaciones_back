<?php

use yii\db\Migration;

/**
 * Class m220128_160945_create_table_obras
 */
class m220128_160945_create_table_obras extends Migration
{

    public function safeUp()
    {
        $this->createTable('obras', [
            'id'                => $this->primaryKey(),
            'nombre_alias'      => $this->string()->notNull(),
            'habilitada'        => $this->integer(1)->notNull(),
        ]);
    }

    public function safeDown()
    {
        echo "m220128_160945_create_table_obras cannot be reverted.\n";
        return false;
    }

}
