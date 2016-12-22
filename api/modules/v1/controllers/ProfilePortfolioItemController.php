<?php
 
namespace app\api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider; 
use yii\filters\auth\HttpBearerAuth;
use app\models\ProfilePortfolioItem;
use app\models\Profile;
use \yii\web\UploadedFile;

class ProfilePortfolioItemController extends ActiveController
{
 
    public $modelClass = 'app\models\ProfilePortfolioItem';
    
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
        //$model = new ProfilePortfolioItem;
        $profile = Profile::findByUid(Yii::$app->user->getId()); 
        if((!$profile->ispremium)&&($profile->portfolioCount>2)){
            return ['error'=> 'only for premium'];
        }
        $model = new $this->modelClass();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        //::findByUid(Yii::$app->user->getId())
//        return $profile->portfolioCount;
        $model->profileid = $profile->id;
        $image = UploadedFile::getInstanceByName('image');
        //return $image;
        $model->image = $image;
        
        if ($model->validate(['image']) && $image) {
            $dir = Yii::getAlias('../web/images/portfolio/');
            $fileName = md5($model->image->baseName. time()) . '.' . $model->image->extension;
            $model->image->saveAs($dir . $fileName);
            $model->image = $fileName;
        }
        if ($model->save()) {
            return $model;
        }
    }
    public function actionUpdate($id)
    {
        $model = ProfilePortfolioItem::findByUid($id);
        $profile = Profile::findByUid(Yii::$app->user->getId());
        if($profile->id !== $model->profileid){
            return ['error'=>'you can change only own portfolio'];
        }
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        
        if (!$model->save()) {
            return array_values($model->getFirstErrors())[0];
        }
        return $model;
    }
    public function actionDelete($id)
    {
        $model = ProfilePortfolioItem::findByUid($id);
        $profile = Profile::findByUid(Yii::$app->user->getId());
        if($profile->id !== $model->profileid){
            return ['error'=>'you can delete only own recall'];
        }

        return $model->delete();
    }
    
}

 