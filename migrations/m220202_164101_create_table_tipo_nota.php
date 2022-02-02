<?php

use yii\db\Migration;

/**
 * Class m220202_164101_create_table_tipo_nota
 */
class m220202_164101_create_table_tipo_nota extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tipo_nota', [
            'id'                => $this->primaryKey(),
            'nombre'            => $this->string()->notNull(),
            'color'             => $this->string()->notNull(),
        ]);

        $this->addColumn('nota', 'tipo_nota_id', $this->integer());
        $this->addForeignKey(
            'fk_nota_tipo_nota_id',
            'nota','tipo_nota_id',
            'tipo_nota','id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220202_164101_create_table_tipo_nota cannot be reverted.\n";
        return false;
    }
}
