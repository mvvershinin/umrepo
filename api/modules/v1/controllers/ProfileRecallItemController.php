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
        $model = new $this->modelClass();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        //::findByUid(Yii::$app->user->getId())
        $profile = Profile::findByUid(Yii::$app->user->getId());
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
}

 