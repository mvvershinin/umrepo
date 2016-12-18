<?php
 
namespace app\api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider; 
use yii\filters\auth\HttpBearerAuth;
use app\models\ProfilePortfolioItem;
use app\models\Profile;
use \yii\web\UploadedFile;

class ChatBlockController extends ActiveController
{
 
    public $modelClass = 'app\models\BlockTable';
    
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
        unset($actions['index'], /*$actions['update'],*/ $actions['create'], $actions['delete']/* $actions['view']*/);
        return $actions;
    }
     public function actionCreate()
    {
        $model = new $this->modelClass();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        $profile = Profile::findByUid(Yii::$app->user->getId());
        $model->blockedby = $profile->id;
        if ($model->save()) {
            return $model;
        }
    }
    public function actionDelete()
    {
        $params = Yii::$app->getRequest()->getBodyParams();
        return $params['t'];
        //return $this->findModel($id)->delete();
    }
}

 