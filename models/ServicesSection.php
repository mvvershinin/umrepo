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
            'one_id',
            'layer' => function () {
                return 'section';
            },
            //'section_name',
            'name'=> function () {
                return $this->section_name;
            },
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
            [['one_id'], 'string', 'max' => 32],
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
    
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->one_id = md5($this->id. $this->section_name);
            return true;
        }
        return false;
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
