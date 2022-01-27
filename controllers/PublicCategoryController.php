<?php
namespace app\controllers;

use Yii;
use yii\rest\ActiveController;
use app\models\Category;

class PublicCategoryController extends PublicBaseController {

    public function actions(){
        $actions = parent::actions();
        unset( $actions['delete'],
               $actions['create'],
               $actions['update'],
               $actions['index'],
             );
  
        return $actions;
    }

    public $modelClass = 'app\models\Category';

    public function actionIndex(){
        $params = Yii::$app->request->queryParams;

        $query = Category::find();
        
        if (isset($params['root_category_id'])){
            $query->where(['root_category_id' => $params['root_category_id']]);
        }

        $query = $query->all();
        
        return ['items' => $query]; 
    }
}