<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
	/*
	 * @comment: Table name
	 * */
	public static function tableName()
	{
		return 'users';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['username', 'password'], 'required'],
			[['username', 'password'], 'string', 'max' => 100]
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id'       => 'User Id',
			'username' => 'Username',
			'password' => 'Password'
		];
	}

	/*
	 * @comment: Event for generating new auth key
	 * */
	public function beforeSave($insert)
	{
		if (parent::beforeSave($insert))
		{
			if ($this->isNewRecord)
			{
				$this->auth_key = \Yii::$app->security->generateRandomString();
			}

			return true;
		}

		return false;
	}

	/**
	 * Finds an identity by the given ID.
	 *
	 * @param string|int $id the ID to be looked for
	 *
	 * @return IdentityInterface|null the identity object that matches the given ID.
	 */
	public static function findIdentity($id)
	{
		return static::findOne($id);
	}

	/**
	 * Finds an identity by the given token.
	 *
	 * @param string $token the token to be looked for
	 *
	 * @return IdentityInterface|null the identity object that matches the given token.
	 */
	public static function findIdentityByAccessToken($token, $type = null)
	{
		return static::findOne(['access_token' => $token]);
	}

	/**
	 * @return int|string current user ID
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return string current user auth key
	 */
	public function getAuthKey()
	{
		return $this->auth_key;
	}

	/**
	 * @param string $authKey
	 *
	 * @return bool if auth key is valid for current user
	 */
	public function validateAuthKey($authKey)
	{
		return $this->getAuthKey() === $authKey;
	}

	/**
	 * Finds user by username
	 *
	 * @param string $username
	 *
	 * @return static|null
	 */
	public static function findByUsername($username)
	{
		return static::findOne(['username' => $username]);
	}

	public static function hash_pass($password)
	{
		return sha1(sha1($password . Yii::$app->params['salt']) . Yii::$app->params['salt']);
	}

	/**
	 * Validates password
	 *
	 * @param string $username username $password password to validate
	 *
	 * @return bool if password provided is valid for current user
	 */
	public function validatePassword($username, $password)
	{
		return (static::findOne(['username' => $username, 'password' => self::hash_pass($password)]) !== null);
	}

	/**
	 * Check if activated
	 *
	 * @param string $username username to validate if activated
	 *
	 * @return bool if user is activated
	 */
	public function is_activated($username)
	{
		return (static::findOne(['username' => $username, 'is_activated' => 1]) !== null);
	}

	/**
	 * Activate
	 *
	 * @param string $key activation key
	 *
	 * @return bool if user is activated
	 */
	public static function activate($key)
	{
		return (static::updateAll(['is_activated' => 1, 'activation_token' => null], ['activation_token' => $key]) > 0);
	}

	/**
	 * Check if role exist
	 *
	 * @param string $username username to validate if activated
	 *
	 * @return bool if user is activated
	 */
	public static function is_role($role)
	{
		return UserRoles::role($role, Yii::$app->user->getId());
	}

	/**
	 * Check if role action exist
	 *
	 * @param string $role find action by role name
	 *
	 * @return bool if exist
	 */
	public static function is_role_action($role, $action)
	{
		return RoleAction::role_action($role, $action);
	}
}
