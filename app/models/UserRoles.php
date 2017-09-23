<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_roles".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $role_id
 * @property string  $date_assigned
 */
class UserRoles extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'user_roles';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['user_id', 'role_id'], 'required'],
			[['user_id', 'role_id'], 'integer']
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id'            => 'User Role ID',
			'user_id'       => 'User ID',
			'role_id'       => 'Role ID',
			'date_assigned' => 'Date Assigned',
		];
	}

	/**
	 * Check if user have a role
	 *
	 * @param string $role to validate if user have role
	 *
	 * @return bool if user have role
	 */
	public static function role($role, $user_id)
	{
		return (static::find()
				->select('`user_roles`.`id`')
				->leftJoin('roles', "`roles`.`name` = '{$role}'")
				->where("`user_roles`.`user_id` = '{$user_id}' AND `user_roles`.`role_id` = `roles`.`id`")->one() !== null);
	}
}
