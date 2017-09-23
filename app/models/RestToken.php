<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rest_token".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $token
 * @property string $private_key
 * @property string $public_key
 * @property integer $day_limit
 * @property string $valid_till
 * @property string $created_date
 */
class RestToken extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rest_token';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'token', 'private_key', 'public_key'], 'required'],
            [['user_id', 'day_limit'], 'integer'],
            [['valid_till', 'created_date'], 'safe'],
            [['token'], 'string', 'max' => 255],
            [['private_key', 'public_key'], 'string', 'max' => 125],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'REST token ID',
            'user_id' => 'User ID',
            'token' => 'Token',
            'private_key' => 'Private Key',
            'public_key' => 'Public Key',
            'day_limit' => 'Day request Limit',
            'valid_till' => 'Valid Till',
            'created_date' => 'Created Date',
        ];
    }
}
