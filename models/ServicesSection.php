<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "services_section".
 *
 * @property integer $id
 * @property string $section_name
 * @property string $description
 * @property string $picture
 * @property integer $sort
 * @property string $color
 *
 * @property Service[] $services
 */
class ServicesSection extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $name;
    public static function tableName()
    {
        return 'services_section';
    }
    public function fields()
    {
        return [
            'id',
            'one_id' => function($model){
                return md5($model->id. $model->section_name);
            },
            'section_name',
            'description',
            'sort',
            'picture',
            'color',
            'services' => function ($model) {
                return $model->services;
            },
                    
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['section_name'], 'required'],
            [['sort'], 'integer'],
            [['section_name', 'description'], 'string', 'max' => 255],
            [['color'], 'string', 'max' => 7],
            [['picture'], 'file','extensions'=> ['jpg', 'jpeg', 'bmp', 'png']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'section_name' => 'название',
            'description' => 'описание',
            'picture' => 'изображение',
            'sort' => 'сортировка',
            'color' => 'цвет',
            'servicesName' => 'разделы',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServices()
    {
        return $this->hasMany(Service::className(), ['section' => 'id']);
    }
    
    /**
     * @inheritdoc
     * @return ServicesSectionQuery the active query used by this AR class.
     *
    
    public static function find()
    {
        return new ServicesSectionQuery(get_called_class());
    }
     * 
     */
}
