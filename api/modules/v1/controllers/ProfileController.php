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
            'index' => [
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
                       ]);//->joinWith(['sections' ])->where(['one_id'=>'3b40601f0d43290d5733213c671941cd']);
                       
                   //$query->joinWith(['sections' ])->where(['one_id'=>'3b40601f0d43290d5733213c671941cd']);
                   $query->joinWith(['services' ])->where(['one_id'=>'8fd77622d1853592f51d47633c9a880f']);
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
            'index2' => [
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