<?php

use yii\db\Migration;

/**
 * Class m220203_190344_add_field_imagen_id_obras
 */
class m220203_190344_add_field_imagen_id_obras extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('obras', 'imagen_id', $this->integer());
        $this->addForeignKey(
            'fk_obras_imagen_id',
            'obras','imagen_id',
            'imagenes','id'
        );

        $this->alterColumn('imagenes', 'id_nota', $this->integer()); 
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220203_190344_add_field_imagen_id_obras cannot be reverted.\n";
        return false;
    }
}
