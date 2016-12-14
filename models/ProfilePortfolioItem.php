<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "profile_portfolio_item".
 *
 * @property integer $id
 * @property integer $profileid
 * @property string $image
 * @property string $description
 * @property string $service_one_id
 *
 * @property Profile $profile
 */
class ProfilePortfolioItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile_portfolio_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['profileid', 'image', 'description'], 'required'],
            [['profileid'], 'integer'],
            [['description'], 'string'],
            [['serviceoneid', 'servicelayer'], 'string', 'max' => 255],
            [['image'], 'file','extensions'=> ['jpg', 'jpeg', 'bmp', 'png']],
            //[['profileid'], 'exist', 'skipOnError' => true, 'targetClass' => Profile::className(), 'targetAttribute' => ['profileid' => 'id']],
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
            'image' => 'Image',
            'description' => 'Description',
            'serviceoneid' => 'service_one_id',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'profileid']);
    }
}
