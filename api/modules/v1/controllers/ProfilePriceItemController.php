<?php
 
namespace app\api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider; 
use yii\filters\auth\HttpBearerAuth;
use app\models\ProfilePortfolioItem;
use app\models\Profile;
use app\models\ProfilePriceItem;
use \yii\web\UploadedFile;

class ProfilePriceItemController extends ActiveController
{
 
    public $modelClass = 'app\models\ProfilePriceItem';
    
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
        unset($actions['index'], $actions['update'], $actions['create'], $actions['delete'], $actions['view']);
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
    public function actionUpdate($id)
    {
        $model = ProfilePriceItem::findByUid($id);
        $profile = Profile::findByUid(Yii::$app->user->getId());
        if($profile->id !== $model->profileid){
            return ['error'=>'you can change only own recall'];
        }
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        
        if (!$model->save()) {
            return array_values($model->getFirstErrors())[0];
        }
        return $model;
    }
    public function actionDelete($id)
    {
        $model = ProfilePriceItem::findByUid($id);
        $profile = Profile::findByUid(Yii::$app->user->getId());
        if($profile->id !== $model->profileid){
            return ['error'=>'you can delete only own recall'];
        }

        return $model->delete();
    }
}

 