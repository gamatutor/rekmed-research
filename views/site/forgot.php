<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Lupa Password';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if ($flash = Yii::$app->session->getFlash('Forgot-success')): ?>

    <div class="alert alert-success">
        <p><?= $flash ?></p>
    </div>

<?php endif; ?>

<div class="site-login">
    <div class="form-title">
        <span class="form-title">Lupa Password.</span>
        <span class="form-subtitle">Silahkan Input Email Anda.</span>
    </div>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "<div class=\"col-lg-12\">{input}</div>\n<div class=\"col-lg-12\">{error}</div>",
        ],
    ]); ?>

        <?= $form->field($model, 'email')->textInput(['autofocus' => true,'placeholder'=>'Email']) ?>

        <div class="form-actions">
                <?= Html::submitButton('Send Email', ['class' => 'btn red btn-block uppercase', 'name' => 'login-button']) ?>
                <br>
                
                 <center> <a href="http://app.rekmed.com">Kembali</a> </center>
        </div>
       
    <?php ActiveForm::end(); ?>
</div>
