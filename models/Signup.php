<?php 

namespace app\models;

use yii\base\Model;
use app\models\User;
use yii\db\ActiveRecord;


class Signup extends Model

{
    //public $username;
    public $phone;
    //public $email;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //['username', 'trim'],
            //['username', 'required'],
            //['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Логин занят'],
            //['username', 'string', 'max' => 15],

            //['email', 'trim'],
            //['email', 'required'],
            //['email', 'email'],
            //['email', 'string', 'max' => 255],
            //['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Электронный адрес занят'],
            
            ['phone', 'trim'],
            ['phone', 'required'],
            ['phone', 'string', 'length' => 11],
            ['phone', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Телефон занят'],
            
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        //if(!$this->username) $this->username = 'umka'.$this->phone;
        if(!$this->password){
            //send password via sms;
            $this->password = '7777';
        } 
        return $this->password;
        if (!$this->validate()) {
            return null;
        }
       
        $user = new User();
        $user->username = 'umka'.$this->phone;
        $user->email = $this->phone .'@umka.ru';
        $user->phone = $this->phone;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        if (!$user->validate()) {
            return null;
        }
        
        return $user->save() ? $user : null;
    }
}