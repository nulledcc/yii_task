<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rest_request_log".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $rest_token_id
 * @property string $ip
 * @property string $first_request
 */
class RestRequestLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rest_request_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'rest_token_id', 'ip'], 'required'],
            [['user_id', 'rest_token_id'], 'integer'],
            [['ip'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'REST request ID',
            'user_id' => 'User ID',
            'rest_token_id' => 'Rest Token ID',
            'ip' => 'Ip',
            'first_request' => 'First Request Timestamp',
        ];
    }
}
