<?php
namespace app\controllers;

use Yii;
use yii\rest\ActiveController;

class PrivateEstadoController extends BaseController {

    public function actions(){
        $actions = parent::actions();
        return $actions;
    }

    public $modelClass = 'app\models\Estado';

}