<?php

namespace app\models;

use Yii;
use app\models\Nota;

/**
 * This is the model class for table "estado".
 *
 * @property int $id
 * @property string $nombre
 * @property int $categoria_id
 *
 * @property Categoria $categoria
 * @property Nota[] $notas
 */
class Estado extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estado';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'categoria_id'], 'required'],
            [['categoria_id'], 'integer'],
            [['nombre'], 'string', 'max' => 255],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::className(), 'targetAttribute' => ['categoria_id' => 'id']],
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
            'categoria_id' => 'Categoria ID',
        ];
    }

    /**
     * Gets query for [[Categoria]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categoria::className(), ['id' => 'categoria_id']);
    }

    /**
     * Gets query for [[Notas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNotas()
    {
        return $this->hasMany(Nota::className(), ['estado_id' => 'id']);
    }

    public function beforeDelete() {
        $notas = Nota::find()->where( [ 'estado_id' => $this->id ] )->all();
        
        if ( $notas != NULL || count($notas) > 0 ) {
            throw new \Exception( 'El estado no puede eliminarse por que tiene notas asociadas.', 400 );
        }

        return true;
    }
}
