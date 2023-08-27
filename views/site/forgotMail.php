<?php

use yii\helpers\Url;
use yii\helpers\Html;

/**
 * @var string $subject
 * @var \amnah\yii2\user\models\User $user
 * @var \amnah\yii2\user\models\UserToken $userToken
 */
?>

<h3><?= Html::encode($subject) ?></h3>

<p><?= "Please use this link to reset your password:" ?></p>

<p><?= Url::toRoute(["/user/reset", "token" => $userToken->token], true); ?></p>
