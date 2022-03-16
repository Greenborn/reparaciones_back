<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "imagenes".
 *
 * @property int $id
 * @property string $url
 * @property int $id_nota
 *
 * @property Nota $nota
 */
class Imagenes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'imagenes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
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

    public function beforeDelete() {
        if (!empty($this->url) && file_exists($this->url)) {
            unlink($this->url);
            // echo 'se elimnó la img';
        }

        return true;
    }

    public function beforeSave($insert) {
        
        $params = Yii::$app->getRequest()->getBodyParams();
        $date   = new \DateTime();
        if (isset($params['base64_edit'])){
            if ($this->url == '-'){
                $this->url = 'public/images/'.$date->getTimestamp().$params['name'];
            }

            if (!empty($this->url) && file_exists($this->url)) {
                unlink($this->url);
                // echo 'se elimnó la img';
            }

            $file_name = $this->url;
            $this->base64_to_file($params['base64_edit'], $file_name);
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
