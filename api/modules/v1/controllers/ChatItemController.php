<?php
 
namespace app\api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider; 
use yii\filters\auth\HttpBearerAuth;
use app\models\Profile;
use app\models\BlockTable;
use \yii\web\UploadedFile;

class ChatItemController extends ActiveController
{
 
    public $modelClass = 'app\models\ChatItem';
    
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
        unset($actions['index'], /*$actions['update'],*/ $actions['create']/* $actions['delete'] $actions['view']*/);
        return $actions;
    }
    
 /* @property integer $fromprofileid
 * @property integer $toprofileid
 * @property string $message
 * @property integer $isread
 * @property string $image
  * 
  */
     public function actionMessages()
    {
        $modelClass = $this->modelClass;
        $profile = Profile::findByUid(Yii::$app->user->getId());
        $params = Yii::$app->getRequest()->getBodyParams();
        $query = $modelClass::find()->orFilterWhere([
                            'fromprofileid' => $profile->id,
                            'toprofileid' => $params['toprofileid'],
                       ])->orFilterWhere([
                            'toprofileid' => $profile->id,
                            'fromprofileid' => $params['toprofileid'],
                       ])->orderBy((['datetime' => SORT_DESC]));
        /*
                ->where("fromprofileid = AND (status = 1 OR verified = 1) OR (social_account = 1 AND enable_social = 1)")
            ->all();
                /*
                 * 
                 */

        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }
     public function actionCreate()
    {
        $profile = Profile::findByUid(Yii::$app->user->getId());
        
        $params = Yii::$app->getRequest()->getBodyParams();
        if(BlockTable::findBlock($profile->id, $params['toprofileid'])){
            return 'blocked';
        }
         
        
        $model = new $this->modelClass();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        $model->isread = 0;
        $model->fromprofileid = $profile->id;
        $model->datetime = time();
        /*
        $image = UploadedFile::getInstanceByName('image');
        $model->image = $image;
        if ($model->validate(['image']) && $image) {
            $dir = Yii::getAlias('../web/images/chat/');
            $fileName = md5($model->image->baseName. time()) . '.' . $model->image->extension;
            $model->image->saveAs($dir . $fileName);
            $model->image = $fileName;
        }
         * 
         */

        if ($model->save()) {
            return $model;
        }
    }
    /*
    public function actionDelete()
    {
        $params = Yii::$app->getRequest()->getBodyParams();
        $profileid = $params['profileid'];
        $blockedby = Profile::findByUid(Yii::$app->user->getId());
        return BlockTable::findBlock($profileid, $blockedby->id)->delete();
    }
     * 
     */
}

 