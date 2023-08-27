<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\GolonganObat */

$this->title = 'Update Golongan Obat: ' . $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Golongan Obat', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nama, 'url' => ['view', 'id' => $model->nama]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="golongan-obat-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
