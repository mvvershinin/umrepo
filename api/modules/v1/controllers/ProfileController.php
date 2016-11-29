<?php
 
namespace app\api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider; 
use app\models\Profile;


class ProfileController extends ActiveController
{
 
    public $modelClass = 'app\models\Profile';

    public function actions()
    {
        
        return [
            'list' => [
                'class' => 'yii\rest\IndexAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'prepareDataProvider' =>  function ($action) {
                   $modelClass = $this->modelClass;
                   $request = Yii::$app->request;
                   // returns all parameters
                   $params = $request->bodyParams;
                   // returns the parameter "id"
                   //$param = $request->getBodyParam('data');
                   //return $params;
                   
                   $query = $modelClass::find()->andFilterWhere([
                            'is_master' => 1,
                       ]);
                   //if(Yii::$app->request->getBodyParam('level') && Yii::$app->request->getBodyParam('one_id'))
                   //{}
                        $level = Yii::$app->request->getBodyParam('level');
                        $one_id = Yii::$app->request->getBodyParam('one_id');
                        $query->joinWith([$level])->where(['one_id'=>$one_id]);
                   
                   //вывод по категориям 
                   //curl -X GET http://localhost:86/api/v1/profile/index -d level=services -d one_id=cc2685f55383a82c4f390240b1389979


                   return new ActiveDataProvider([
                        'query' => $query,
                        'pagination' => [
                            'pageSize' => 10,
                        ],
                   ]);
                 }
            ],
            'view' => [
                'class' => 'yii\rest\ViewAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
            ],
            'index3' => [
                'class' => 'yii\rest\IndexAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'prepareDataProvider' =>  function ($action) {
                   $modelClass = $this->modelClass;
                   return new ActiveDataProvider([
                        'query' => $modelClass::find()->andFilterWhere([
                            'is_master' => 0,
                        ]),
                       'pagination' => [
                            'pageSize' => 10,
                        ],
                   ]);
                 }
            ],
        ];
    } 
    
}