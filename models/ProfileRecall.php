<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "profile_recall".
 *
 * @property integer $id
 * @property integer $fromprofileid
 * @property integer $profileid
 * @property integer $rating
 * @property double $totalrating
 * @property integer $datetime
 * @property integer $message
 */
class ProfileRecall extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile_recall';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fromprofileid', 'profileid', 'rating'], 'required'],
            [['fromprofileid', 'profileid', 'rating', 'datetime'], 'integer'],
            [['totalrating'], 'number'],
            [['message'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fromprofileid' => 'Fromprofileid',
            'profileid' => 'Profileid',
            'rating' => 'Rating',
            'totalrating' => 'Totalrating',
            'datetime' => 'Datetime',
            'message' => 'Message',
        ];
    }
    public static function findExist($fromprofile, $toprofile)
    {
        if ($recall = static::findOne(['fromprofileid' => $fromprofile, 'profileid' => $toprofile])) {
            return $recall;
        }
        return 0;
    }
    public static function findLast($toprofile)
    {
        if ($recall = static::findOne(['profileid' => $toprofile])) {
            return $recall;
        }
        return NULL;
    }
    public static function findByUid($id)
    {
        return static::findOne(['id' => $id]);
    }
}
