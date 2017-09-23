<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class RegisterForm extends Model
{
    public $username;
    public $password;
    public $repeat_password;
    public $email;
	public $activation_key;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['email','username', 'password','repeat_password'], 'required'],
	        ['repeat_password', 'compare', 'compareAttribute'=>'password' , 'message'=>"Passwords don't match"]
        ];
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function register()
    {
        if ($this->validate()) {
			$user = new User();
	        $user->email = $this->email;
			$user->username = $this->username;
			$user->password = User::hash_pass($this->password);
			$this->activation_key = $user->activation_token = md5(uniqid().rand(1,9999));
			$user->created_date = gmdate("Y-m-d H:i:s");
			$user->ip = Yii::$app->request->userIP;
			return $user->save();

        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
