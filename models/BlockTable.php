<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "block_table".
 *
 * @property integer $id
 * @property integer $profileid
 * @property integer $blockedby
 * @property string $reason
 * @property integer $date
 */
class BlockTable extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'block_table';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['profileid', 'blockedby', 'reason', 'date'], 'required'],
            [['profileid', 'blockedby', 'date'], 'integer'],
            [['reason'], 'string', 'max' => 255],
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
            'blockedby' => 'Blockedby',
            'reason' => 'Reason',
            'date' => 'Date',
        ];
    }
}
