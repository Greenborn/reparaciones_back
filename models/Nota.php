<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "nota".
 *
 * @property int $id
 * @property string $nota
 * @property int $categoria_id
 * @property int $estado_id
 * @property int $obra_id
 * @property string|null $vencimiento
 * @property int|null $orden
 *
 * @property Documents[] $documents
 * @property Images[] $images
 * @property Categoria $categoria
 * @property Estado $estado
 * @property Obras $obra
 */
class Nota extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nota';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nota', 'categoria_id', 'estado_id', 'obra_id'], 'required'],
            [['nota'], 'string'],
            [['categoria_id', 'estado_id', 'obra_id', 'orden'], 'integer'],
            [['vencimiento'], 'safe'],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::className(), 'targetAttribute' => ['categoria_id' => 'id']],
            [['estado_id'], 'exist', 'skipOnError' => true, 'targetClass' => Estado::className(), 'targetAttribute' => ['estado_id' => 'id']],
            [['obra_id'], 'exist', 'skipOnError' => true, 'targetClass' => Obras::className(), 'targetAttribute' => ['obra_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nota' => 'Nota',
            'categoria_id' => 'Categoria ID',
            'estado_id' => 'Estado ID',
            'obra_id' => 'Obra ID',
            'vencimiento' => 'Vencimiento',
            'orden' => 'Orden',
        ];
    }

    /**
     * Gets query for [[Documents]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDocuments()
    {
        return $this->hasMany(Documents::className(), ['id_nota' => 'id']);
    }

    /**
     * Gets query for [[Images]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(Images::className(), ['id_nota' => 'id']);
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
     * Gets query for [[Estado]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEstado()
    {
        return $this->hasOne(Estado::className(), ['id' => 'estado_id']);
    }

    /**
     * Gets query for [[Obra]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getObra()
    {
        return $this->hasOne(Obras::className(), ['id' => 'obra_id']);
    }

    public function extraFields() {
        return [ 'categoria', 'obra' ];
    }
}
