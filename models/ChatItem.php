<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "chat_item".
 *
 * @property integer $id
 * @property integer $datetime
 * @property integer $fromprofileid
 * @property integer $toprofileid
 * @property string $message
 * @property integer $isread
 * @property string $image
 */
class ChatItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chat_item';
    }
/*
    public function fields()
    {
        return [

            'id'=> function ($model) {
                return $model->id;
            },
            'fromprofileid',
            'toprofileid',
            'message',
            'image',
            'isread',
            'datetime',
                    
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fromprofileid', 'toprofileid', 'message'], 'required'],
            [['datetime', 'fromprofileid', 'toprofileid', 'isread'], 'integer'],
            [['message'], 'string'],
            [['image'], 'file','extensions'=> ['jpg', 'jpeg', 'bmp', 'png']],
            //[['image'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'datetime' => 'Datetime',
            'fromprofileid' => 'Fromprofileid',
            'toprofileid' => 'Toprofileid',
            'message' => 'Message',
            'isread' => 'Isread',
            'image' => 'Image',
        ];
    }
}
