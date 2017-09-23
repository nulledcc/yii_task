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
class ResendActivationForm extends Model
{
    public $username;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username'], 'required']
        ];
    }
	/**
	 * Finds activation token user by [[username]]
	 *
	 * @return string |null
	 */
	public function getActivationToken()
	{
		return User::findOne(['username' => $this->username])->activation_token;
	}
	/**
	 * Finds email by [[username]]
	 *
	 * @return string |null
	 */
	public function getEmail()
	{
		return User::findOne(['username' => $this->username])->email;
	}
}
