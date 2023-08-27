<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "access_history".
 *
 * @property string $id
 * @property string $user
 * @property string $ip_address
 * @property string $host
 * @property string $url
 * @property string $time_akses
 */
class AccessHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'access_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user', 'ip_address', 'host', 'url','agent'], 'string'],
            [['time_akses'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user' => 'User',
            'ip_address' => 'Ip Address',
            'host' => 'Host',
            'url' => 'Url',
            'agent' => 'Agent',
            'time_akses' => 'Time Akses',
        ];
    }

    public function saveAccess()
    {
        $model = new AccessHistory();
        $model->host = Yii::$app->request->userHost;
        $model->ip_address = Yii::$app->request->userIP;
        $model->agent = Yii::$app->request->userAgent;
        $model->user = isset(Yii::$app->user->identity->username) ? Yii::$app->user->identity->username : '';
        $model->url = Yii::$app->request->absoluteUrl;
        $model->save();
    }
}
