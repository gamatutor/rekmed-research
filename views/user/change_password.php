<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Klinik;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
$this->title = 'Ganti Password';
/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'newPassword')->passwordInput() ?>
<?= $form->field($model, 'newPasswordConfirm')->passwordInput() ?>

<div class="form-group">
    <?= Html::submitButton('Ganti Password', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
</div>

<?php ActiveForm::end(); ?>
            

    

