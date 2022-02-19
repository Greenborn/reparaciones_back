<?php

use yii\db\Migration;

/**
 * Class m220219_092515_agregar_campo_nombre
 */
class m220219_092515_agregar_campo_nombre extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('documentos', 'nombre', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220219_092515_agregar_campo_nombre cannot be reverted.\n";

        return false;
    }

}
