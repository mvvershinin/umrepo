<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "service_spec".
 *
 * @property integer $id
 * @property integer $service
 * @property string $name
 * @property string $description
 * @property integer $sort
 * @property string $picture
 * @property string $color
 *
 * @property Service $service
 */
class ServiceSpec extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'service_spec';
    }
    public function fields()
    {
        return [
            'id',
            'one_id',
            'layer' => function () {
                return 'specs';
            },
            'spec_name',
            'description',
            'sort',
            'picture',
            'color',
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['spec_name'], 'required'],
            [['service', 'sort'], 'integer'],
            [['spec_name', 'description', 'picture'], 'string', 'max' => 255],
            [['color'], 'string', 'max' => 7],
            [['one_id'], 'string', 'max' => 32],
            [['service'], 'exist', 'skipOnError' => true, 'targetClass' => Service::className(), 'targetAttribute' => ['service' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'service' => 'Service',
            'name' => 'Name',
            'description' => 'Description',
            'sort' => 'Sort',
            'picture' => 'Picture',
            'color' => 'Color',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(Service::className(), ['id' => 'service']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->one_id = md5($this->id. $this->spec_name);
            return true;
        }
        return false;
    }
    /**
     * @inheritdoc
     * @return ServiceSpecQuery the active query used by this AR class.
     *
    public static function find()
    {
        return new ServiceSpecQuery(get_called_class());
    }
     * 
     */
}
