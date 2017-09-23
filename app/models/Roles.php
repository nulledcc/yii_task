<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "roles".
 *
 * @property integer $id
 * @property string $name
 * @property integer $level
 * @property string $created_date
 */
class Roles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'roles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'level'], 'required'],
            [['level'], 'integer'],
            [['name'], 'string', 'max' => 25],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Role ID',
            'name' => 'Name',
            'level' => 'Level',
            'created_date' => 'Created Date',
        ];
    }
}
