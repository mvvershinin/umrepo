<?php

namespace app\models;

use Yii;


/**
 * This is the model class for table "rel_profile_section".
 *
 * @property integer $id
 * @property integer $profile_id
 * @property string $section_one_id
 *
 * @property Profile $profile
 * @property ServicesSection $sectionOne
 */
class RelProfileSection extends \yii\db\ActiveRecord
{

    
    public static function tableName()
    {
        return 'rel_profile_section';
    }

    public function rules()
    {
        return [
            [['profile_id', 'section_one_id'], 'required'],
            [['profile_id'], 'integer'],
            [['section_one_id'], 'string', 'max' => 32],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::className(), 'targetAttribute' => ['profile_id' => 'id']],
            [['section_one_id'], 'exist', 'skipOnError' => true, 'targetClass' => ServicesSection::className(), 'targetAttribute' => ['section_one_id' => 'one_id']],
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
            'section_one_id' => 'Section One ID',
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
    public function getSectionOne()
    {
        return $this->hasOne(ServicesSection::className(), ['one_id' => 'section_one_id']);
    }
    public static function findById($id)
    {
        return static::findOne(['id' => $id]);
    }
}
