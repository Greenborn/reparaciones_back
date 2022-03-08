<?php
namespace app\actions;

use Yii;
use yii\rest\UpdateAction;
use yii\helpers\Url;
use app\models\User;
use yii\web\BadRequestHttpException;

class ChangePasswordAction extends UpdateAction {

    public function run($id) {
      $params = Yii::$app->getRequest()->getBodyParams();
      
      $authHeader = getallheaders()['Authorization'];
      $authHeader = explode('Bearer ',$authHeader)[1]; 
      $user = User::find()->where(['access_token' => $authHeader])->one();

      $old_password = isset($params['old_password']) ? $params['old_password'] : null;
      $new_password = isset($params['new_password']) ? $params['new_password'] : null;

      $response = Yii::$app->getResponse();
      $response->format = \yii\web\Response::FORMAT_JSON;

      if ($new_password && $old_password){
        $transaction = User::getDb()->beginTransaction();
        $status = Yii::$app->getSecurity()->validatePassword($old_password, $user->password_hash);
        if($status){
            $user->password_hash = Yii::$app->getSecurity()->generatePasswordHash($new_password);
            if($user->save()){
                $transaction->commit();
                $response->data = [
                    'status' => $status,
                    'id'   => $user->id
                ];
            }else{
                $transaction->rollBack();
                $response->data = [
                     'status' => false,
                     'message' => 'Error no se pudo cambiar la contraseña!',
                ];                   
            }
        }else{
          $response->data = [
               'status' => false,
               'message' => '¡Contraseña equivocada!',
          ];                   
        }
      } else{
        $response->data = [
             'status' => false,
             'message' => 'Faltan datos',
        ];                   
    }
 }
}