<?php
 
namespace app\api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider; 
use yii\filters\auth\HttpBearerAuth;
use app\models\ProfileAvatar;
use app\models\Profile;
use \yii\web\UploadedFile;

class ProfileAvatarController extends ActiveController
{
 
    public $modelClass = 'app\models\ProfileAvatar';
    
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
        unset(/*$actions['index'], $actions['update']*/ $actions['create']/*, $actions['delete']*/, $actions['view']);
        return $actions;
    }
     public function actionCreate()
    {
        $model = ProfileAvatar::findByUid(Yii::$app->user->getId());
        //$profile = Profile::findByUid(Yii::$app->user->getId());
        $image = UploadedFile::getInstanceByName('avatar');
        $model->avatar = $image;
        if ($model->validate(['avatar']) && $image) {
            $dir = Yii::getAlias('../web/images/avatars/');
            $fileName = md5($model->avatar->baseName. time()) . '.' . $model->avatar->extension;
            $model->avatar->saveAs($dir . $fileName);
            $model->avatar = $fileName;
        }
        if ($model->save()) {
            return $model;
        }
    }
}

 