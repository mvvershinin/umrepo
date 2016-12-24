<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_login_history".
 *
 * @property integer $id
 * @property string $lon
 * @property string $lat
 * @property string $ip4
 * @property integer $datetime
 * @property integer $uid
 */
class UserLoginHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_login_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['lon', 'lat', 'ip4', 'dateime', 'uid'], 'required'],
            [['datetime', 'uid'], 'integer'],
            [['lon', 'lat', 'ip4'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lon' => 'Lon',
            'lat' => 'Lat',
            'ip4' => 'Ip4',
            'datetime' => 'Dateime',
            'uid' => 'Uid',
        ];
    }
}
