<?php
 
namespace app\api\modules\v1\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;

class SignupController extends ActiveController
{
//'test' => Yii::$app->request->userIP,
    public $modelClass = 'app\models\User';
 /*
    public function behaviors()
    {
        $behaviors = parent::behaviors();
 
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
        ];
 
        return $behaviors;
    }
  * 
  */
  /*  public function actionView($id)
{
    return User::findOne($id);
}
   * 
   */
}

