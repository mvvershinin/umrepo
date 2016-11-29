<?php
 
namespace app\api\modules\v1\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;
use app\models\LoginForm;
use app\models\Signup;
use app\models\Profile;
use yii\web\JsonParser;
use yii\web\Request;

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
    
    public function actionListServiceProfiles($level = null, $one_id = null, $gender = null)
        {
            $query = Profile::find()->andFilterWhere([
                            'is_master' => 1,
                       ]);
            $query->joinWith([$level])->where(['one_id'=>$one_id]);
            if(!is_null($gender)) $query->andFilterWhere([
                            'like', 'gender', $gender
                       ]);
            
            //return $gender;
            return new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);
        }    
}