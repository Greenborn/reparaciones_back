<?php

namespace app\models;

use Yii;
use  app\models\Imagenes;
use  app\models\Documentos;
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
 * @property int|null $tipo_nota_id
 *
 * @property Documentos[] $documentos
 * @property Imagenes[] $imagenes
 * @property Categoria $categoria
 * @property Estado $estado
 * @property Obras $obra
 * @property TipoNota $tipoNota
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
            [['categoria_id', 'estado_id', 'obra_id', 'orden', 'tipo_nota_id'], 'integer'],
            [['vencimiento'], 'safe'],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::className(), 'targetAttribute' => ['categoria_id' => 'id']],
            [['estado_id'], 'exist', 'skipOnError' => true, 'targetClass' => Estado::className(), 'targetAttribute' => ['estado_id' => 'id']],
            [['obra_id'], 'exist', 'skipOnError' => true, 'targetClass' => Obras::className(), 'targetAttribute' => ['obra_id' => 'id']],
            [['tipo_nota_id'], 'exist', 'skipOnError' => true, 'targetClass' => TipoNota::className(), 'targetAttribute' => ['tipo_nota_id' => 'id']],
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
            'tipo_nota_id' => 'Tipo Nota ID',
        ];
    }

    /**
     * Gets query for [[Documentos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDocumentos()
    {
        return $this->hasMany(Documentos::className(), ['id_nota' => 'id']);
    }

    /**
     * Gets query for [[Imagenes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImagenes()
    {
        return $this->hasMany(Imagenes::className(), ['id_nota' => 'id']);
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

    /**
     * Gets query for [[TipoNota]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTipoNota()
    {
        return $this->hasOne(TipoNota::className(), ['id' => 'tipo_nota_id']);
    }

    public function extraFields() {
        return [ 'categoria', 'obra', 'tipoNota', 'imagenes', 'documentos' ];
    }

    public function afterSave($insert, $changedAttributes) {
        $params = Yii::$app->getRequest()->getBodyParams();
        $date   = new \DateTime();
        if (isset($params['images'])){
            for ($c=0; $c < count($params['images']); $c++){
                if (isset($params['images'][$c]['fromnota'])){
                    continue;
                }
                $file_name = 'public/images/'.$date->getTimestamp().$params['images'][$c]['name'];
                $this->base64_to_file($params['images'][$c]['file'], $file_name);
                $img                = new Imagenes();
                $img->id_nota       = $this->id;
                $img->url           = $file_name;
                $img->save(false);
            }
        }

        if (isset($params['documents'])){
            for ($c=0; $c < count($params['documents']); $c++){
                if (isset($params['documents'][$c]['fromnota'])){
                    continue;
                }
                $file_name = 'public/documents/'.$date->getTimestamp().$params['documents'][$c]['name'];
                $this->base64_to_file($params['documents'][$c]['file'], $file_name);
                $img                = new Documentos();
                $img->id_nota       = $this->id;
                $img->url           = $file_name;
                $doc->nombre = $params['documents'][$c]['name'];
                $img->save(false);
            }
        }
        return parent::afterSave($insert, $changedAttributes);
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
