<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "profile".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $avatar
 * @property string $firstname
 * @property string $patronymic
 * @property string $lastname
 * @property string $gender
 * @property string $about
 * @property integer $is_master
 * @property integer $location_place_id
 * @property integer $work_place_id
 *
 * @property User $user
 */
class ProfileAvatar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profile';
    }

    public function fields()
    {
        return [
            'id',
            'uid',
            'avatar',
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['avatar'], 'string', 'max' => 255],
            [['avatar'], 'file','extensions'=> ['jpg', 'jpeg', 'bmp', 'png']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'avatar' => 'Avatar',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'uid']);
    }
    public static function findByUid($uid)
    {
        return static::findOne(['uid' => $uid]);
    }
    public function search($params)
    {
        $query = Profile::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'uid' => $this->uid,
            'is_master' => $this->is_master,
            'location_place_id' => $this->location_place_id,
            'work_place_id' => $this->work_place_id,
        ]);

        $query->andFilterWhere(['like', 'avatar', $this->avatar])
            ->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'patronymic', $this->patronymic])
            ->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'about', $this->about]);

        return $dataProvider;
    }
    
    
    /**
     * @inheritdoc
     * @return ProfileQuery the active query used by this AR class.
     **/
    public static function find()
    {
        return new ProfileQuery(get_called_class());
    }
     /* 
     */
      
     
}
