<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "profile_schedule_item".
 *
 * @property integer $id
 * @property integer $profileid
 * @property string $day
 * @property string $time
 * @property integer $select
 */
class ProfileScheduleItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile_schedule_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['day', 'time', 'select'], 'required'],
            [['profileid', 'select'], 'integer'],
            [['day'], 'safe'],
            //[['time'], 'string', 'max' => 11],
            ['time', 'in', 'range' => [
                '8:00-9:00',
                '9:00-10:00',
                '10:00-11:00',
                '11:00-12:00',
                '12:00-13:00',
                '13:00-14:00',
                '14:00-15:00',
                '15:00-16:00',
                '16:00-17:00',
                '17:00-18:00',
                '18:00-19:00',
                '19:00-20:00',
                '20:00-21:00',
                '21:00-22:00',
                ], 'strict' => true],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'profileid' => 'Profileid',
            'day' => 'Day',
            'time' => 'Time',
            'select' => 'Select',
        ];
    }
        public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'profileid']);
    }
    
}
