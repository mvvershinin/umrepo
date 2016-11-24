<?php
 
namespace app\api\modules\v1\controllers;

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
                   return new ActiveDataProvider([
                        'query' => $modelClass::find()->andFilterWhere([
                            'is_master' => 1,
                        ]),
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