<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "obras".
 *
 * @property int $id
 * @property string $nombre_alias
 * @property int $habilitada
 * @property int|null $imagen_id
 *
 * @property Nota[] $notas
 * @property Imagenes $imagen
 */
class Obras extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'obras';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_alias', 'habilitada'], 'required'],
            [['habilitada', 'imagen_id'], 'integer'],
            [['nombre_alias'], 'string', 'max' => 255],
            [['imagen_id'], 'exist', 'skipOnError' => true, 'targetClass' => Imagenes::className(), 'targetAttribute' => ['imagen_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre_alias' => 'Nombre Alias',
            'habilitada' => 'Habilitada',
            'imagen_id' => 'Imagen ID',
        ];
    }

    /**
     * Gets query for [[Notas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNotas()
    {
        return $this->hasMany(Nota::className(), ['obra_id' => 'id']);
    }

    /**
     * Gets query for [[Imagen]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImagen()
    {
        return $this->hasOne(Imagenes::className(), ['id' => 'imagen_id']);
    }

    public function extraFields() {
        return [ 'notas', 'imagen' ];
    }
}
