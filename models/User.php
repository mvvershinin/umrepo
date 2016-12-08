<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use app\models\Profile;
/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $phone
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */

class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    /**
     * @inheritdoc
     *
     * 
     */
    public function fields()
    {
        return [
            'id',
            'username',
            'email',
            'phone',
            'profile' => function ($model) {
                return $model->profiles->id;
            }
            /*
            'name' => function ($model) {
                return $model->first_name . ' ' . $model->last_name;
            },
             * 
             **/
        ];
    }
    public function rules()
    {
        return [
            ['phone', 'trim'],
            ['phone', 'required'],
            ['phone', 'string', 'length' => 11],
            ['phone', 'unique', 'message' => 'Телефон занят'],
            
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }
    public static function findByPhone($phone)
    {
        return static::findOne(['phone' => $phone]);
    }
    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByIdentity($identity)
    {
        if ($user = static::findOne(['phone' => $identity, 'status' => self::STATUS_ACTIVE])) {
            return $user;
        }
        /*
        if ($user = static::findOne(['email' => $identity, 'status' => self::STATUS_ACTIVE])) {
            return $user;
        }
        if ($user = static::findOne(['username' => $identity, 'status' => self::STATUS_ACTIVE])) {
            return $user;
        }*/
        return ['error' => 'user not found'];
        
    }
    
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }
    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }
        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }
    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }
    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }
    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }
    /*public function getAuthKey()
    {
        return $this->auth_key;
    }*/
    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }
    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }
    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }
    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
 /*   
    public function signup()//$phone)
    {
        $params = Yii::$app->getRequest()->getBodyParams();
        $phone = $params['phone'];
        $user = new User();
        $user->username = 'umka'.$phone;
        $user->email = $phone .'@umka.ru';
        $user->phone = $phone;
        //$user->password = '7777';
        $user->setPassword('7777');
        $user->generateAuthKey();
        if (!$user->validate()) {
            return null;
        }
        return $user->save() ? $user : null;
    }
*/  public function signup()//$phone)
    {
        $params = Yii::$app->getRequest()->getBodyParams();
        $phone = $params['phone'];
        $user = new User();
        $user->username = 'umka'.$phone;
        $user->email = $phone .'@umka.ru';
         
        $user->phone = $phone;
          
         
        //$user->password = '7777';
        $user->setPassword('7777');
        $user->generateAuthKey();
        if (!$user->validate()) {
            return $user->validate();
        }
        
        
        return $user->save() ? $user : null;
    }
    
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            //$this->one_id = md5($this->id. $this->serv_name);
/*            
            $params = Yii::$app->getRequest()->getBodyParams();
            $phone = $params['phone'];
            
            $this->username = 'umka'.$phone;
            $this->email = $phone .'@umka.ru';
            $this->phone = $phone;
            //$user->password = '7777';
            $this->setPassword('7777');
            $this->generateAuthKey();
            return $phone;
 * 
 */
            return true;
        }
        return false;
    }
    
    public function afterSave($insert,$changedAtrr) {
            
            if($insert){  
            $model = new Profile;
            $model->uid = $this->id;
            //$model->avatar = md5($model->uid. time()) . '.jpg';
            $model->firstname = '';
            $model->patronymic = '';
            
            $model->gender = 'мужской';
            
            $model->is_master = true;
            $model->location_place_id = 70;
            $model->work_place_id = 70;
            $model->save();
            }
            parent::afterSave($insert,$changedAtrr);
            /* else {
             * 
             Profile::model()->updateAll(array( 'uid' =>$this->id, 
                                                'name' => $this->name,    
                                                'first_name'=>$this->first_name,
                                                'description'=>$this->description
                    ), 'user_id=:user_id', array(':user_id'=> $this->id));
            }*/
        }
    public function getProfiles()
    {
        return $this->hasOne(Profile::className(), ['uid' => 'id']);
    }
    public function getProfile()
    {
         return $this->profiles->id;
    }
}
