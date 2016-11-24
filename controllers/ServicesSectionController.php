<?php

namespace app\controllers;

use Yii;
use app\models\ServicesSection;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Gd;
use Imagine\Image\Box;
use Imagine\Image\BoxInterface;
use yii\helpers\ArrayHelper;


/**
 * ServicesSectionController implements the CRUD actions for ServicesSection model.
 */
class ServicesSectionController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ServicesSection models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ServicesSection::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ServicesSection model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ServicesSection model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ServicesSection();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->id]);
            $picture = UploadedFile::getInstance($model, 'picture');
	    $this->savesection($model, $picture);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ServicesSection model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //return $this->redirect(['view', 'id' => $model->id]);
            $picture = UploadedFile::getInstance($model, 'picture');
	    $this->savesection($model, $picture);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    public function Savesection($model, $file)
    {
            if ($file && $file->tempName) {
                $model->picture = $file;
                if ($model->validate(['picture']) && $file) {
                    $dir = Yii::getAlias('images/');
                    $fileName = md5($model->picture->baseName. time()) . '.' . $model->picture->extension;
                    $model->picture->saveAs($dir . $fileName);
                    $model->picture = $fileName; 
                    //resize picture 
                    //$photo = Image::getImagine()->open($dir . $fileName);
                    //$photo->thumbnail(new Box(800, 800))->save($dir . $fileName, ['quality' => 90]);
                    //$photo->thumbnail(new Box(200, 200))->save($dir .'thumbs/'. $fileName, ['quality' => 80]);
		    //$model->picture = $fileName; 
                }
            } 
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }	
    }
    /**
     * Deletes an existing ServicesSection model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ServicesSection model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ServicesSection the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ServicesSection::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
