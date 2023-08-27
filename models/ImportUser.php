<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "import_user".
 *
 * @property string $email
 * @property double $password_default
 */
class ImportUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'import_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password_default'], 'number'],
            [['email'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => 'Email',
            'password_default' => 'Password Default',
        ];
    }
}
