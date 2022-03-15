<?php

namespace app\models;

use Yii;
use app\models\Nota;

/**
 * This is the model class for table "tipo_nota".
 *
 * @property int $id
 * @property string $nombre
 * @property string $color
 *
 * @property Nota[] $notas
 */
class TipoNota extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipo_nota';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'color'], 'required'],
            [['nombre', 'color'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'color' => 'Color',
        ];
    }

    /**
     * Gets query for [[Notas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNotas()
    {
        return $this->hasMany(Nota::className(), ['tipo_nota_id' => 'id']);
    }

    public function beforeDelete() {
        $notas = Nota::find()->where( [ 'tipo_nota_id' => $this->id ] )->all();
        
        if ( $notas != NULL || count($notas) > 0 ) {
            throw new \Exception( 'El tipo de nota no puede eliminarse por que tiene notas asociadas.', 400 );
        }

        return true;
    }
}
