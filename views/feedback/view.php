<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Feedback */

$this->title = 'Detail Feedback';
$this->params['breadcrumbs'][] = ['label' => 'Feedbacks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="general-item-list">
    <div class="item">
        <div class="item-head">
            <div class="item-details">
                <span class="item-name primary-link"><?= $nama ?></span></div>
                <span class="item-label"><?= $model->created ?></span>
        </div>
        <div class="item-body"><?= \yii\helpers\HtmlPurifier::process($model->isi) ?></div>
    </div>
    <?php foreach($feedback_reply as $val): ?>
    <div class="item">
        <div class="item-head">
            <div class="item-details">
                <span class="item-name primary-link"><?= $val['is_admin']==1 ? '<span class="badge badge-empty badge-danger"></span> Admin' : '<span class="badge badge-empty badge-primary"></span> '.$nama ?></span></div>
                <span class="item-label"><?= $val['created'] ?></span>
        </div>
        <div class="item-body"><?=\yii\helpers\HtmlPurifier::process($val['isi']) ?></div>
    </div>
    <?php endforeach; ?>
</div>

<h4>Kirim Balasan</h4>
<div class="feedback-form">

    <?php $form = ActiveForm::begin(); ?>



    <?= \yii\redactor\widgets\Redactor::widget([
        'model' => $model_reply,
        'attribute' => 'isi'
    ]) ?>
    <div class="form-group">
        <?= Html::submitButton('Kirim Balasan', ['class'=>'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
