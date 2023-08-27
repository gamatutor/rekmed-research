<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\swiftmailer\Mailer;
use yii\swiftmailer\Message;
use app\models\User;
use app\models\UserToken;
use yii\helpers\Url;
use yii\helpers\Html;


/**
 * Forgot password form
 */
class ForgotForm extends Model
{
    /**
     * @var string Username and/or email
     */
    public $email;

    /**
     * @var \amnah\yii2\user\models\User
     */
    protected $user = false;

    /**
     * @var \amnah\yii2\user\Module
     */
    public $module;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (!$this->module) {
            $this->module = Yii::$app->getModule("user");
        }
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ["email", "required"],
            ["email", "email"],
            ["email", "validateEmail"],
            ["email", "filter", "filter" => "trim"],
        ];
    }

    /**
     * Validate email exists and set user property
     */
    public function validateEmail()
    {
        // check for valid user
        $this->user = $this->getUser();
        if (!$this->user) {
            $this->addError("email", "Email Tidak Ditemukan");
        }
    }

    /**
     * Get user based on email
     * @return \amnah\yii2\user\models\User|null
     */
    public function getUser()
    {
        // get and store user
        if ($this->user === false) {
            $user = new User();
            $this->user = $user::findOne(["email" => $this->email]);
        }
        return $this->user;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            "email" => "Email",
        ];
    }

    /**
     * Send forgot email
     * @return bool
     */
    public function sendForgotEmail()
    {
        /** @var Mailer $mailer */
        /** @var Message $message */
        /** @var \amnah\yii2\user\models\UserToken $userToken */

        if ($this->validate()) {

            // get user
            $user = $this->getUser();

            // calculate expireTime
            $expireTime = "2 days";
            $expireTime = $expireTime ? gmdate("Y-m-d H:i:s", strtotime($expireTime)) : null;

            // create userToken
            $userToken = new UserToken();
            $userToken = $userToken::generate($user->id, $userToken::TYPE_PASSWORD_RESET, null, $expireTime);

            // modify view path to module views
            // $mailer = Yii::$app->mailer;
            // $oldViewPath = $mailer->viewPath;
            // $mailer->viewPath = "@app/views/site";

            // send email
            $subject = "Rekmed.com - Lupa Password";
             
            $teks = "Seseorang telah meminta untuk mereset password anda, jika itu adalah anda maka silahkan reset password dengan meng-copy link berikut ini ke browser, jika bukan anda, maka hiraukan saja email ini. ";
            $teks .= Url::toRoute(["/site/reset", "token" => $userToken->token], true);

            $param = [
                'subject' => $subject,
                'detail' => "Seseorang telah meminta untuk mereset password anda, jika itu adalah anda maka silahkan reset password dengan mengikuti tautan berikut, jika bukan anda, maka abaikan saja email ini. ",
                'url' => Url::toRoute(["/site/reset", "token" => $userToken->token], true)
            ];
            Yii::$app->mailer->view->params = $param;
            Yii::$app->mailer->compose('@app/mail/layouts/html')
             ->setFrom('admin@rekmed.com')
             ->setTo($user->email)
             ->setSubject($subject)
             // ->setTextBody($subject)
             ->send();


            // restore view path and return result
            // $mailer->viewPath = $oldViewPath;
            return true;
        }

        return false;
    }
}