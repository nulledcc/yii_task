<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "role_action".
 *
 * @property integer $id
 * @property string $name
 * @property string $date_created
 */
class RoleAction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'role_action';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 25],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Role Action ID',
            'name' => 'Name',
            'date_created' => 'Date Created',
        ];
    }
	/**
	 * Check if role action exist
	 *
	 * @param string $role find action by role name
	 *
	 * @return bool if exist
	 */
	public static function role_action($role, $action)
	{
		return (static::find()
				->select('`role_action`.`id`')
				->leftJoin('roles', "`roles`.`name` = '{$role}'")
				->rightJoin('role_actions_relation', "`role_actions_relation`.`role_id` = `roles`.`id`")
				->where(['`role_action`.`name`' => $action])->one() !== null);
	}
}
