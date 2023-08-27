<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "template_soap".
 *
 * @property integer $id
 * @property string $nama_template
 * @property string $subject
 * @property string $object
 * @property string $assesment
 * @property string $plan
 * @property integer $user
 * @property string $created
 */
class TemplateSoap extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'template_soap';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['subject', 'object', 'assesment', 'plan'], 'string'],
            [['user'], 'integer'],
            [['created'], 'safe'],
            [['nama_template'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama_template' => 'Nama Template',
            'subject' => 'Subject',
            'object' => 'Object',
            'assesment' => 'Assesment',
            'plan' => 'Plan',
            'user' => 'Username',
            'created' => 'Created',
        ];
    }

    public function getUser0()
    {
        return $this->hasOne(User::className(), ['id' => 'user']);
    }
}
