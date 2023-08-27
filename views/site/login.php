<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\RekmedLoginAsset;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
RekmedLoginAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicon.png">
    <title>REKMED | Halaman Masuk Sistem</title>
    <!-- Bootstrap Core CSS -->
    <!-- Custom CSS -->
    <!-- You can change the theme colors from here -->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    <?= Html::csrfMetaTags() ?>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>

    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <section id="wrapper" class="login-register login-sidebar" style="background-image:url(<?= Url::to('@web/assets/new_rekmed_asset/img/login-register.jpg')?>);">
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
                    <div class="form-group m-t-40">
                        <div class="col-xs-12">
                            <?= $form->field($model, 'username')->textInput(['autofocus' => true,'placeholder'=>'Username','required'=>""])->label(false) ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                        <?= $form->field($model, 'password')->passwordInput(['placeholder'=>'Password','required'=>""])->label(false) ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="checkbox checkbox-primary pull-left p-t-0">
                                <?= $form->field($model, 'rememberMe')->checkbox(['id'=>'checkbox-signup',
                                    'template' => "{input} <label for='checkbox-signup'> Ingat saya </label>",
                                ]) ?>
                            </div>
                            <a href="javascript:void(0)" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> Lupa pwd?</a> </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <?= Html::submitButton('MASUK', ['class' => 'btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light', 'name' => 'login-button']) ?>
                        </div>
                    </div>
                    <div class="form-group m-b-0">
                        <div class="col-sm-12 text-center">
                            <p>Belum memiliki akun? <a href="<?= Url::to(['site/signup']) ?>" class="text-primary m-l-5"><b>DAFTAR REKMED</b></a></p>
                        </div>
                        <div class="col-sm-12 text-center">
                          <!--  <p>Atau coba <a href="<?= Url::to(['site/demo']) ?>" class="text-primary m-l-5"><b>DEMO REKMED</b></a></p> -->
                        </div>
                    </div>
                    <div class="form-group">
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 m-t-10 text-center">
                            <div class="social"><a href="http://rekmed.com" class="btn  btn-facebook" data-toggle="tooltip" title="Ke Halaman Utama"> 
                            <i aria-hidden="true" class="fa fa-home"></i> <!--</a> <a href="http://blog.rekmed.com" class="btn btn-twitter" data-toggle="tooltip" title="Blog REKMED"> 
                            <i aria-hidden="true" class="fa fa-feed"></i> --> 
                            </a> <a href="https://api.whatsapp.com/send?phone=6281228944870" class="btn btn-googleplus" data-toggle="tooltip" title="Kontak Kami"> <i aria-hidden="true" class="fa fa-phone"></i> </a> </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div style="width: 100%; height: 100%">
                            <iframe src="https://app.rekmed.com/berita/list" style="width:100%; height:100%" frameborder="0"></iframe>
                        </div>
                    </div>
                <?php ActiveForm::end(); ?>

                <?php $form = ActiveForm::begin([
                    'id' => 'recoverform',
                    'options' => ['class' => 'form-horizontal'],
                    'action'=>['site/forgot'],
                    'fieldConfig' => [
                        'template' => "{input}<div style='color:red'>{error}</div>",
                    ],
                ]); ?>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <h3>Recover Password</h3>
                            <p class="text-muted">Masukkan Email anda dan instruksi akan dikirimkan ke email anda!</p>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                        <?= $form->field($forgot, 'email')->textInput(['required'=>'','autofocus' => true,'placeholder'=>'Email']) ?>
                        </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <?= Html::submitButton('Reset', ['class' => 'btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light', 'name' => 'login-button']) ?>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal fade" id="preventClick" data-backdrop="false" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">FORGOT PASSWORD</h4>
                    </div>
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">TUTUP</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <!-- Bootstrap tether Core JavaScript -->
    <!-- slimscrollbar scrollbar JavaScript -->
    <!--Wave Effects -->
    <!--Menu sidebar -->
    <!--stickey kit -->
    <!--Custom JavaScript -->



<?php

$script = <<< JS
    $(function(){
        $('body').on('beforeSubmit', 'form#recoverform', function () {
            var form = $(this);
            alert("Permintaan anda sedang kami proses...");
            // // return false if form still have some validation errors
            // if (form.find('.has-error').length) 
            // {
            //     return false;
            // }
            // // submit form
            $.ajax({
            url    : form.attr('action'),
            type   : 'post',
            data   : form.serialize(),
            success: function (response) 
            {
                $('#preventClick').modal('show').find('.modal-body').html(response);

                // alert(response);
                // var getupdatedata = $(response).find('#filter_id_test');
                // // $.pjax.reload('#note_update_id'); for pjax update
                // $('#yiiikap').html(getupdatedata);
                // //console.log(getupdatedata);
            },
            error  : function () 
            {
                console.log('internal server error');
            }
            });
            return false;
         });
    });
JS;

$this->registerJs($script);
?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>