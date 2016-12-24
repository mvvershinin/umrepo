<?php
 
namespace app\api\modules\v1\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\Controller;
use app\models\LoginForm;
use app\models\User;
use app\models\Profile;
use app\models\UserLoginHistory;
use yii\web\JsonParser;
use yii\web\Request;


class MainController extends Controller 
{
    
    
    public function actionLogin()
    {
        $model = new LoginForm();
        $params = Yii::$app->getRequest()->getBodyParams();
        //return Yii::$app->request->userIP;
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->login()) {
            $history = new UserLoginHistory;
            $history->ip4 = Yii::$app->request->userIP; 
            $history->lon = $params['lon'];  
            $history->lat = $params['lat'];  
            $history->datetime = time();
            $history->uid = Yii::$app->user->getId();
            if($history->validate())
                $history->save();
            
            return [
                'access_token' => Yii::$app->user->identity->getAuthKey(),
                'profile' => $model->user,
                    ];
        } else {
            $model->validate();
            //return false;
            return $model;
        }
    }

    public function actionSignup1()//$phone)
    {
        //return Yii::$app->getRequest()->getBodyParams();
        $params = Yii::$app->getRequest()->getBodyParams();
        $phone = $params['phone'];
        //return $phone;
        if(strlen($phone)<11){
            return ['error' => 'phone invalid'];
        }
        $user = User::findByPhone($phone, null);
        if($user){
            return $user;
            return array_merge(['message' => 'user exist. new user code send'], $user);
        }
        return User::signup();
    }
    
    public function actionListServiceProfiles($level = null, $one_id = null, $gender = null)
        {
            $query = Profile::find()->andFilterWhere([
                            'is_master' => 1,
                       ]);
            $level = $level.'s';
            $query->joinWith([$level])->where(['one_id'=>$one_id]);
            if(!is_null($gender)) $query->andFilterWhere([
                            'like', 'gender', $gender
                       ]);
            return new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);
        }    
    public function actionTest() {
        return Yii::$app->user->getId();
    }    
}