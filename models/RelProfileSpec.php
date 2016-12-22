<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rel_profile_spec".
 *
 * @property integer $id
 * @property integer $profile_id
 * @property string $spec_one_id
 */
class RelProfileSpec extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rel_profile_spec';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['profile_id', 'spec_one_id'], 'required'],
            [['profile_id'], 'integer'],
            [['spec_one_id'], 'string', 'max' => 32],
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
            'spec_one_id' => 'Spec One ID',
        ];
    }
    public static function findById($id)
    {
        return static::findOne(['id' => $id]);
    }
}
