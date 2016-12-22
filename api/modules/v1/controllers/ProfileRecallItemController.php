<?php
 
namespace app\api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider; 
use yii\filters\auth\HttpBearerAuth;
use app\models\ProfileRecall;
use app\models\Profile;
//use \yii\web\UploadedFile;

class ProfileRecallItemController extends ActiveController
{
 
    public $modelClass = 'app\models\ProfileRecall';
    
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
        $profile = Profile::findByUid(Yii::$app->user->getId());
        $params = Yii::$app->getRequest()->getBodyParams();
        if($existrecall = ProfileRecall::findExist($profile, $params['profileid'])){
                return array_merge(['message' => 'recall exist, you may update it'],['id'=> $existrecall->id]);
        };
        $model = new $this->modelClass();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        $model->fromprofileid = $profile->id;
        $model->datetime = time();
        $last = ProfileRecall::findLast($params['profileid']);
        if(is_object($last)){
            $model->recallcount = $last['recallcount'] + 1;
            $model->totalrating = ($last['totalrating'] + $params['rating'])/ $model->recallcount;
            
        }else{
            $model->totalrating = $params['rating'];
            $model->recallcount = 1;
        };
        if ($model->save()) {
            return $model;
        }
    }
    public function actionUpdate($id)
    {
        $model = ProfileRecall::findByUid($id);
        $profile = Profile::findByUid(Yii::$app->user->getId());
        //return $model;
        //return $profile->id.'&&&'.$model->fromprofileid;
        if($profile->id !== $model->fromprofileid){
            return ['error'=>'you can change only own recall'];
        }
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        $last = ProfileRecall::findLast($params['profileid']);
        if(is_object($last)){
            $model->recallcount = $last['recallcount'] + 1;
            $model->totalrating = ($last['totalrating'] + $params['rating'])/ $model->recallcount;
            
        }
        if (!$model->save()) {
            return array_values($model->getFirstErrors())[0];
        }
        return $model;
    }
    public function actionDelete($id)
    {
        $model = ProfileRecall::findByUid($id);
        $profile = Profile::findByUid(Yii::$app->user->getId());
        //return $model;
        //return $profile->id.'&&&'.$model->fromprofileid;
        if($profile->id !== $model->fromprofileid){
            return ['error'=>'you can delete only own recall'];
        }
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        $last = ProfileRecall::findLast($params['profileid']);
        if(is_object($last)){
            $model->recallcount = $last['recallcount'] - 1;
            $model->totalrating = ($last['totalrating'] - $params['rating'])/ $model->recallcount;
            
        }
        return $model->delete();
    }
}

 