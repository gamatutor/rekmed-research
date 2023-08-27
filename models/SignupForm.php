<?php
namespace app\models;

use app\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $klinik_id;
    public $password2;
    public $role;
    public $apps_id;
    public $apps;
    public $SK;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This username has already been taken.'],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This Email has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            [['username', 'email', 'password', 'password2','SK'], 'required', 'on'=>'signup'],
            ['SK', 'compare', 'compareValue' => 1, 'operator' => '>=', 'on'=>'signup', 'message' => 'Anda harus menyetujui ketentuan yang berlaku.'],
            ['password2', 'compare', 'compareAttribute'=>'password', 'message'=>"Passwords didn't match" ],
            ['email', 'email'],
            ['role','required', 'except' => 'signup'],
            ['klinik_id','required', 'except' => 'signup'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {

        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->role = $this->role;
            $user->klinik_id = $this->klinik_id;
            $user->apps = $this->apps;
            $user->apps_id = $this->apps_id;
            $user->generateAuthKey();
            
            $user->created_at = date('Y-m-d H:i:s');
            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }

    public function attributeLabels()
    {
        return [
            'ruang_id' => 'Ruang',
            'role' => 'Role',
            'klinik_id' => 'Klinik',
            'username' => 'Username',
            'password' => 'Password',
            'password2' => 'Konfirmasi Password',
            'SK' => 'Saya setuju dengan terms rekmed.com',

        ];
    }
}
