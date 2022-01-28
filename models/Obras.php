<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "obras".
 *
 * @property int $id
 * @property string $nombre_alias
 * @property int $habilitada
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
            [['habilitada'], 'integer'],
            [['nombre_alias'], 'string', 'max' => 255],
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
        ];
    }
}
