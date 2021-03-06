<?php
 
namespace app\api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider; 
use yii\filters\auth\HttpBearerAuth;
use app\models\RelProfileSection;
use app\models\Profile;


class RelProfileSectionController extends ActiveController
{
 
    public $modelClass = 'app\models\RelProfileSection';
    
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
        unset($actions['index'], /*$actions['update'],*/ $actions['create'], $actions['delete'], $actions['view']);
        return $actions;
    }
     public function actionCreate()
    {
        $model = new $this->modelClass();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        //$model->profile_id = Yii::$app->user->getId();getProfile()
        //$model->profile_id = Yii::$app->user->getProfile();
        $profile = Profile::findByUid(Yii::$app->user->getId());
        $model->profile_id = $profile->id;
        if (!$model->save()) {
            return array_values($model->getFirstErrors())[0];
        }
        return $model;
    }
    public function actionDelete($id)
    {
        $model = RelProfileSection::findById($id);
        $profile = Profile::findByUid(Yii::$app->user->getId());
        if($profile->id !== $model->profile_id){
            return ['error'=>'you can delete only own recall'];
        }

        return $model->delete();
    }
}

/*
 * public function actionTest() {
        return Yii::$app->user->getId();
        //['profile_id' => Yii::$app->user->getId(), 'section_one_id']
        
    }  
$model = new $this->modelClass([
            'scenario' => $this->scenario,
        ]);
 
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
if ($model->save()) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
            $id = implode(',', array_values($model->getPrimaryKey(true)));
            $response->getHeaders()->set('Location', Url::toRoute([$this->viewAction, 'id' => $id], true));
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
 
        return $model;
 * */
 