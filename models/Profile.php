<?php

namespace app\models;

use Yii;
use app\models\ServicesSection;
use app\models\Service;
use app\models\ServiceSpec;

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
class Profile extends \yii\db\ActiveRecord
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
            'firstname',
            'patronymic',
            'lastname',
            'rating'=> function ($model) {
                return $model->raiting;
            },
            'phone' => function ($model) {
                return $model->userPhone;
            },
            'gender',
            'about',
            'is_master',
            'location_place_id',
            'work_place_id',
            'portfolio_items' => function ($model) {
                return $model->portfolioItems;
            },
            'services' => function ($model) {
                return array_merge($model->sections, $model->services, $model->specs);
            },
            'servicesPrice' => function ($model) {
                return $model->priceItems;
            },
            /*'servicesPrice' => function ($model) {
                return $model->servicesPrice;
            },
             * 
             */
                    
        ];
    }
    public function extraFields()
    {
        return [
            'servicesPrice' => function ($model) {
                return $model->servicesPrice;
            },
            'testexpand' => function ($model) {
                return $model->testexpand;
            },
            ];
    }
    
    public function behaviors()
    {
        return [
            [
                'class' => \voskobovich\behaviors\ManyToManyBehavior::className(),
                'relations' => [
                    'section_ids' => 'sections',
                    'service_ids' => 'services',
                    'spec_ids' => 'specs',
                ],
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['uid', 'avatar', 'firstname', 'lastname', 'gender', 'location_place_id', 'work_place_id'], 'required'],
            [['is_master', 'location_place_id', 'work_place_id'], 'integer'],
            [['about'], 'string'],
            [['avatar'], 'file','extensions'=> ['jpg', 'jpeg', 'bmp', 'png']],
            [['firstname', 'patronymic', 'lastname'], 'string', 'max' => 100],
            [['gender'], 'string', 'max' => 10],
            //[['uid'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['uid' => 'id']],
            //конфликтует поведение с добавлением основной информации, добавление реляции реалезовано отдельными методами
            //[['section_ids'], 'each', 'rule' => ['integer']],
            //[['service_ids'], 'each', 'rule' => ['integer']],
            //[['spec_ids'], 'each', 'rule' => ['integer']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'avatar' => 'Avatar',
            'firstname' => 'Имя',
            'patronymic' => 'Отчество',
            'lastname' => 'Фамилия',
            'gender' => 'Пол',
            'about' => 'Информация',
            'is_master' => 'Является мастером',
            'location_place_id' => 'Откуда',
            'work_place_id' => 'Работает в',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'uid']);
    }
    public function getSections()
    {
        return $this->hasMany(ServicesSection::className(), ['one_id' => 'section_one_id'])
             ->viaTable('{{%rel_profile_section}}', ['profile_id' => 'id']);
    }
    public function getServices()
    {
        return $this->hasMany(Service::className(), ['one_id' => 'service_one_id'])
             ->viaTable('{{%rel_profile_service}}', ['profile_id' => 'id']);
    }
    public function getSpecs()
    {
        return $this->hasMany(ServiceSpec::className(), ['one_id' => 'spec_one_id'])
             ->viaTable('{{%rel_profile_spec}}', ['profile_id' => 'id']);
    }
    public function getPortfolioItems()
    {
        return $this->hasMany(ProfilePortfolioItem::className(), ['profileid' => 'id']);
    }
    
    public function getPriceItems()
    {
        return $this->hasMany(ProfilePriceItem::className(), ['profileid' => 'id']);
    }

    public function getUserPhone()
    {
        return $this->user->phone;
    }
    public function getRaiting()
    {
        $stars = rand(10, 50)/10;
        return ['stars' => $stars, 'num_votes' => rand(10, 150)];
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
