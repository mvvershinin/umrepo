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
    public function actionTest()
    {
/*$products = Product::listAllByCategoryId($category_id,
            'id, name, category_id, price, featured_price, image_small, short_description')->all();
*/
            
                
                   //$modelClass = $this->modelClass;
                   $request = Yii::$app->request;
                   $params = $request->bodyParams;
                   //$param = $request->getBodyParam('data');
                   //return 'test';
                   //return Yii::$app->request->bodyParams;
                   
                   $query = Profile::find()->andFilterWhere([
                            'is_master' => 1,
                       ]);
                   //if(Yii::$app->request->getBodyParam('level') && Yii::$app->request->getBodyParam('one_id'))
                   //{}
                        $level = Yii::$app->request->getBodyParam('level');
                        $one_id = Yii::$app->request->getBodyParam('one_id');
                     //   $query->joinWith([$level])->where(['one_id'=>$one_id]);
                   
                   //вывод по категориям 
                   //curl -X GET http://localhost:86/api/v1/profile/index -d level=services -d one_id=cc2685f55383a82c4f390240b1389979
                return new ActiveDataProvider([
                        'query' => $query,
                        'pagination' => [
                            'pageSize' => 10,
                        ],
                   ]);
    }
    public function actionListServiceProfiles($level = null, $one_id = null, $gender = null)
        {
            $query = Profile::find()->andFilterWhere([
                            'is_master' => 1,
                       ]);
            if($gender) $query->andFilterWhere([
                            'like', 'gender', $gender
                       ]);
            $query->joinWith([$level])->where(['one_id'=>$one_id]);
            return new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);
        }    
}