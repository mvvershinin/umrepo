<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "service".
 *
 * @property integer $id
 * @property integer $section
 * @property string $serv_name
 * @property string $description
 * @property integer $sort
 * @property string $picture
 * @property string $color
 *
 * @property RelUserMasterService[] $relUserMasterServices
 * @property ServicesSection $section
 * @property ServiceSpec[] $serviceSpecs
 */
class Service extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'service';
    }
    public function fields()
    {
        return [
            'id',
            'one_id',
            'layer'=> function () {
                return 'services';
            },
            'serv_name',
            'description',
            'sort',
            'picture',
            'color',
            'spec' => function ($model) {
                return $model->serviceSpecs;
            },
        ];
    }
    //public $spec = $Service::getServicesSpecArray();
    //$spec = $Service::getServicesSpecArray();
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['serv_name'], 'required'],
            [['section', 'sort'], 'integer'],
            [['serv_name', 'description'], 'string', 'max' => 255],
            [['color'], 'string', 'max' => 7],
            [['one_id'], 'string', 'max' => 32],
            [['section'], 'exist', 'skipOnError' => true, 'targetClass' => ServicesSection::className(), 'targetAttribute' => ['section' => 'id']],
            [['picture'], 'file','extensions'=> ['jpg', 'jpeg', 'png']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sectionName' => 'специализация',
            'serv_name' => 'раздел',
            'description' => 'описание',
            'picture' => 'изображение',
            'sort' => 'сортировка',
            'color' => 'цвет',
            'serviceSpecs' => 'категории',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelUserMasterServices()
    {
        return $this->hasMany(RelUserMasterService::className(), ['service_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSection()
    {
        return $this->hasOne(ServicesSection::className(), ['id' => 'section']);
    }
    
    public function getSectionName()
    {
        return ServicesSection::findOne($this->section)->section_name;
         
        
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceSpecs()
    {
        return $this->hasMany(ServiceSpec::className(), ['service' => 'id']);
    }
    public function getServiceSpecArray()
    {
        return $this->hasMany(ServiceSpec::className(), ['service' => 'id'])->asArray();
    }
    
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->one_id = md5($this->id. $this->serv_name);
            return true;
        }
        return false;
    }
    /**
     * @inheritdoc
     * @return ServiceQuery the active query used by this AR class.
     *
    public static function find()
    {
        return new ServiceQuery(get_called_class());
    }
     * 
     */
}
