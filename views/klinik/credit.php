<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Klinik */

$this->title = $model->klinik_nama;
$this->params['breadcrumbs'][] = ['label' => 'Klinik', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="klinik-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'klinik_nama',
            'maximum_row'
        ],
    ]) ?>

</div>
<div class="klinik-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model_credit, 'penambahan')->textInput(['type' => 'number']) ?>
    <?= $form->field($model_credit, 'biaya')->textInput(['type' => 'number']) ?>

    <div class="form-group">
        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>