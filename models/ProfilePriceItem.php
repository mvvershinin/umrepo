<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "profile_price_item".
 *
 * @property integer $id
 * @property integer $profileid
 * @property string $description
 * @property integer $price
 * @property string $currency
 * @property string $symcur
 * @property integer $quantity
 * @property string $measure
 * @property string $serviceoneid
 * @property string $servicelayer
 */
class ProfilePriceItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile_price_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['profileid', 'currency', 'quantity', 'measure', 'serviceoneid', 'servicelayer'], 'required'],
            [['profileid', 'price', 'quantity'], 'integer'],
            [['description'], 'string'],
            [['currency', 'measure'], 'string', 'max' => 30],
            //[['symcur'], 'string', 'max' => 10],
            [['serviceoneid', 'servicelayer'], 'string', 'max' => 255],
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
            'description' => 'Description',
            'price' => 'Price',
            'currency' => 'Currency',
            'symcur' => 'Currency',
            'quantity' => 'Quantity',
            'measure' => 'Measure',
            'serviceoneid' => 'Serviceoneid',
            'servicelayer' => 'Servicelayer',
        ];
    }
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'profileid']);
    }
}
