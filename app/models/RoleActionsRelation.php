<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "role_actions_relation".
 *
 * @property integer $id
 * @property integer $role_id
 * @property integer $role_action_id
 * @property string $date_assigned
 */
class RoleActionsRelation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'role_actions_relation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_id', 'role_action_id'], 'required'],
            [['role_id', 'role_action_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Role action relation ID',
            'role_id' => 'Role ID',
            'role_action_id' => 'Role Action ID',
            'date_assigned' => 'Date Assigned',
        ];
    }
}
