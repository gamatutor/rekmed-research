<?php
namespace app\models;

use app\models\User;
use yii\base\Model;
use Yii;

class ResetForm extends Model
{
    public $newPassword;
    public $newPasswordConfirm;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // password rules
            [['newPassword'], 'string', 'min' => 3],
            [['newPassword'], 'filter', 'filter' => 'trim'],
            [['newPassword','newPasswordConfirm'], 'required'],
            [['newPasswordConfirm'], 'compare', 'compareAttribute' => 'newPassword', 'message' => 'Password Tidak Cocok'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function resetPassword()
    {

        if ($this->validate()) {
            $user = User::findOne(Yii::$app->user->identity->id);
            $user->setPassword($this->newPassword);
            if ($user->save()) {
                return true;
            }
        }

        return false;
    }

    public function resetPasswordByToken($user_id)
    {

        if ($this->validate()) {
            $user = User::findOne($user_id);
            $user->setPassword($this->newPassword);
            if ($user->save()) {
                return true;
            }
        }

        return false;
    }

    public function attributeLabels()
    {
        return [
            'newPassword' => 'Password Baru',
            'newPasswordConfirm' => 'Ulangi Password Baru',
        ];
    }
}
