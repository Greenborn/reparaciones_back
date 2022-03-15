<?php

namespace app\models;

use Yii;
use Yii\BadRequestHttpException;
use app\models\Estado;
use app\models\Nota;

/**
 * This is the model class for table "categoria".
 *
 * @property int $id
 * @property string $nombre
 * @property string $color
 *
 * @property Estado[] $estados
 * @property Nota[] $notas
 */
class Categoria extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categoria';
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
     * Gets query for [[Estados]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEstados()
    {
        return $this->hasMany(Estado::className(), ['categoria_id' => 'id']);
    }

    /**
     * Gets query for [[Notas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNotas()
    {
        return $this->hasMany(Nota::className(), ['categoria_id' => 'id']);
    }

    public function extraFields() {
        return [ 'estados' ];
    }

    public function beforeDelete() {
        $estados = Estado::find()->where( [ 'categoria_id' => $this->id ] )->all();
        if ( $estados != NULL ) {
            throw new \Exception( 'La categoría no puede eliminarse por que tiene estados asociados.', 400 );
        }

        $nota = Nota::find()->where( [ 'categoria_id' => $this->id ] )->all();
        if ( $nota != NULL ){
            throw new \Exception( 'La categoría no puede eliminarse por que tiene notas asociadas.', 400 );
        }

        return true;
    }
}
