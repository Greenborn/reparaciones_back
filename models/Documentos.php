<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "documentos".
 *
 * @property int $id
 * @property string $url
 * @property int $id_nota
 *
 * @property Nota $nota
 */
class Documentos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'documentos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url', 'id_nota'], 'required'],
            [['url'], 'string'],
            [['id_nota'], 'integer'],
            [['id_nota'], 'exist', 'skipOnError' => true, 'targetClass' => Nota::className(), 'targetAttribute' => ['id_nota' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
            'id_nota' => 'Id Nota',
        ];
    }

    /**
     * Gets query for [[Nota]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNota()
    {
        return $this->hasOne(Nota::className(), ['id' => 'id_nota']);
    }
}
