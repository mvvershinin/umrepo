<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rel_profile_service".
 *
 * @property integer $id
 * @property integer $profile_id
 * @property string $service_one_id
 *
 * @property Profile $profile
 * @property Service $serviceOne
 */
class RelProfileService extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rel_profile_service';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['profile_id', 'service_one_id'], 'required'],
            [['profile_id'], 'integer'],
            [['service_one_id'], 'string', 'max' => 32],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::className(), 'targetAttribute' => ['profile_id' => 'id']],
            [['service_one_id'], 'exist', 'skipOnError' => true, 'targetClass' => Service::className(), 'targetAttribute' => ['service_one_id' => 'one_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'profile_id' => 'Profile ID',
            'service_one_id' => 'Service One ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'profile_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getServiceOne()
    {
        return $this->hasOne(Service::className(), ['one_id' => 'service_one_id']);
    }
}
