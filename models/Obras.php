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

    public function beforeSave($insert) {
        $params = Yii::$app->getRequest()->getBodyParams();
        $date   = new \DateTime();
        
        if ($insert) {
            if (isset($params['imagen_data'])){
                $file_name = 'public/images/'.$date->getTimestamp().$params['imagen_data']['name'];
                $this->base64_to_file($params['imagen_data']['file'], $file_name);
                $img                = new Imagenes();
                $img->url           = $file_name;
                $img->save(false);

                $this->imagen_id = $img->id;
            }
        } else {
            $imagen = Imagenes::find()->where(['id' => $this->imagen_id])->one();
            if ($imagen != NULL){
                $this->imagen_id = NULL;
                $this->save(false);
                $imagen->delete();
            }
            
            if (isset($params['imagen_data'])){
                $file_name = 'public/images/'.$date->getTimestamp().$params['imagen_data']['name'];
                $this->base64_to_file($params['imagen_data']['file'], $file_name);
                $img                = new Imagenes();
                $img->url           = $file_name;
                $img->save(false);

                $this->imagen_id = $img->id;
            }
        }
        return parent::beforeSave($insert);
    }

    private function base64_to_file($base64_string, $output_file) {
        // open the output file for writing
        $ifp = fopen( $output_file, 'wb' ); 
    
        $data = explode( ',', $base64_string );
    
        // we could add validation here with ensuring count( $data ) > 1
        fwrite( $ifp, base64_decode( $data[ 1 ] ) );
    
        // clean up the file resource
        fclose( $ifp ); 
    
        return $output_file; 
    }
}
