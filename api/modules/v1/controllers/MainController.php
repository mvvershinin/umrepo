<?php
 
namespace app\api\modules\v1\controllers;

use Yii;
use yii\rest\Controller;
use app\models\LoginForm;
use app\models\Signup;

class MainController extends Controller 
{

    
    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->login()) {
            return ['access_token' => Yii::$app->user->identity->getAuthKey()];
        } else {
            $model->validate();
            return $model;
        }
    }
    
    public function actionSignup()
    {
        //временно отдает токен сразу после регистрации, без подтверждения
        $model = new Signup();
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '')) {
             if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return ['access_token' => $user->authkey];
                }
            }
        }
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        $model->validate();
            return $model;
    }    
    public function actionTest()
    {
        return ['post' => $_POST];
    }
}