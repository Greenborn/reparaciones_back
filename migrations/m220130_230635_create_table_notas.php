<?php

use yii\db\Migration;

/**
 * Class m220130_230635_create_table_notas
 */
class m220130_230635_create_table_notas extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('categoria', [
            'id'                => $this->primaryKey(),
            'nombre'            => $this->string()->notNull(),
            'color'             => $this->string()->notNull(),
        ]);
        
        $this->createTable('estado', [
            'id'                => $this->primaryKey(),
            'nombre'            => $this->string()->notNull(),
            'categoria_id'      => $this->integer()->notNull()
        ]);
        $this->addForeignKey(
            'fk_estado_categoria_id',
            'estado','categoria_id',
            'categoria','id'
        );

        $this->createTable('nota', [
            'id'                => $this->primaryKey(),
            'nota'              => $this->text()->notNull(),
            'categoria_id'      => $this->integer()->notNull(),
            'estado_id'         => $this->integer()->notNull(),
            'obra_id'           => $this->integer()->notNull(),
            'vencimiento'       => $this->datetime(),
            'orden'             => $this->integer()
        ]);
        $this->addForeignKey(
            'fk_nota_categoria_id',
            'nota','categoria_id',
            'categoria','id'
        );
        $this->addForeignKey(
            'fk_nota_estado_id',
            'nota','estado_id',
            'estado','id'
        );
        $this->addForeignKey(
            'fk_nota_obra_id',
            'nota','obra_id',
            'obras','id'
        );

        $this->createTable('documentos', [
            'id'                => $this->primaryKey(),
            'url'               => $this->text()->notNull(),
            'id_nota'           => $this->integer()->notNull()
        ]);
        $this->addForeignKey(
            'fk_documents_id_nota',
            'documentos','id_nota',
            'nota','id'
        );

        $this->createTable('imagenes', [
            'id'                => $this->primaryKey(),
            'url'               => $this->text()->notNull(),
            'id_nota'           => $this->integer()->notNull()
        ]);
        $this->addForeignKey(
            'fk_images_id_nota',
            'imagenes','id_nota',
            'nota','id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220130_230635_create_table_notas cannot be reverted.\n";
        return false;
    }

}
