<?php
 
namespace app\api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider; 
use yii\filters\auth\HttpBearerAuth;
use app\models\ProfileScheduleItem;
use app\models\Profile;
use \yii\web\UploadedFile;

class ProfileScheduleItemController extends ActiveController
{
 
    public $modelClass = 'app\models\ProfileScheduleItem';
    
    public function behaviors()
    {
        $behaviors = parent::behaviors();
 
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
        ];
 
        return $behaviors;
    }
    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['update'], $actions['create'], /*$actions['delete'],*/ $actions['view']);
        return $actions;
    }
     public function actionCreate()
    {
        $model = new $this->modelClass();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        $profile = Profile::findByUid(Yii::$app->user->getId());
        $model->profileid = $profile->id;
        if ($model->save()) {
            return $model;
        }
    }
    public function actionViewDay()
    {
        $model = new $this->modelClass();
        $params = Yii::$app->getRequest()->getBodyParams();
        $query = $model::find()->andFilterWhere([
                            'day' => $params['day'],
                            'profileid' => $params['profileid'],
                       ]);
        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 14,
            ],
        ]);
    }
}

 