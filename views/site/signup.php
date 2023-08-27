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
      <?php $form = ActiveForm::begin([
                    'id' => 'loginform',
                    'options' => ['class' => 'form-horizontal form-material'],
                    'fieldConfig' => [
                        'template' => "{input}<div style='color:red'>{error}</div>",
                    ],
                ]); ?>
        <a href="javascript:void(0)" class="text-center db"><?= Html::img('@web/assets/new_rekmed_asset/img/logo-icon.png',['alt'=>'Home'])?></a> 
        <h3 class="box-title m-t-40 m-b-0">Daftar Sekarang</h3><small>Buat akun anda dan gunakan REKMED</small> 
        <div class="form-group m-t-20">
          <div class="col-xs-12">
            <?= $form->field($model, 'username')->textInput(['autofocus' => true,'placeholder'=>'Username','required'=>""])->label(false) ?>
          </div>
        </div>
        <div class="form-group ">
          <div class="col-xs-12">
            <?= $form->field($model, 'email')->textInput(['autofocus' => true,'placeholder'=>'Email','required'=>""])->label(false) ?>
          </div>
        </div>
        <div class="form-group ">
          <div class="col-xs-12">
            <?= $form->field($model, 'password')->passwordInput(['placeholder'=>'Password','required'=>""])->label(false) ?>
          </div>
        </div>
        <div class="form-group">
          <div class="col-xs-12">
            <?= $form->field($model, 'password2')->passwordInput(['placeholder'=>'Konfirmasi password','required'=>""]) ?>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12">
            <div class="checkbox checkbox-primary p-t-0">
                <?= $form->field($model, 'SK')->checkbox(['id'=>'checkbox-signup',
                                    'template' => "{input} <label for='checkbox-signup'> Saya menyetujui semua <a href='http://app.rekmed.com/site/terms'>Terms of Use</a></label><div style='color:red'>{error}</div>",
                                ]) ?>
            </div>
          </div>
        </div>
        <div class="form-group text-center m-t-20">
          <div class="col-xs-12">
            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">DAFTAR</button>
          </div>
        </div>
        <div class="form-group m-b-0">
          <div class="col-sm-12 text-center">
            <p>Anda sudah memiliki akun REKMED? <a href="<?= Url::to(['site/login']) ?>" class="text-info m-l-5"><b>MASUK DISINI</b></a></p>
          </div>
        </div>
      <?php ActiveForm::end(); ?>
    </div>
  </div>