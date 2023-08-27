<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
?>
<div class="login-box card">
    <div class="card-body">

    <?php if (!empty($success)): ?>

        <div class="alert alert-success">

            <p>Password Telah di Reset</p>
            <p><?= Html::a("Silahkan Login Disini", Url::to(["site/login"])) ?></p>

        </div>

    <?php elseif (!empty($invalidToken)): ?>

        <div class="alert alert-danger">
            <p>Token Tidak Valid</p>
        </div>

    <?php else: ?>

        <?php $form = ActiveForm::begin([
                    'id' => 'loginform',
                    'options' => ['class' => 'form-horizontal form-material'],
                    'fieldConfig' => [
                        'template' => "{input}<div style='color:red'>{error}</div>",
                    ],
                ]); ?>
        <a href="javascript:void(0)" class="text-center db"><?= Html::img('@web/assets/new_rekmed_asset/img/logo-icon.png',['alt'=>'Home'])?></a> 
        <h3 class="box-title m-t-40 m-b-0">Reset Password Anda</h3><small>Anda Datang ke halaman ini karena Melakukan permintaan reset password ke REKMED</small> 
        <div class="form-group m-t-20">
          <div class="col-xs-12">
            <?= $form->field($reset, 'newPassword')->passwordInput(['placeholder'=>'Ketikan Password Baru','required'=>""])->label(false) ?>
          </div>
        </div>
        <div class="form-group">
          <div class="col-xs-12">
            <?= $form->field($reset, 'newPasswordConfirm')->passwordInput(['placeholder'=>'Konfirmasi password Baru','required'=>""]) ?>
          </div>
        </div>
        <div class="form-group text-center m-t-20">
          <div class="col-xs-12">
            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">RESET PASSWORD</button>
          </div>
        </div>
        <div class="form-group m-b-0">
          <div class="col-sm-12 text-center">
            <p>Anda sudah memiliki akun REKMED? <a href="<?= Url::to(['site/login']) ?>" class="text-info m-l-5"><b>MASUK DISINI</b></a></p>
          </div>
        </div>
      <?php ActiveForm::end(); ?>

    <?php endif; ?>

    </div>
  </div>