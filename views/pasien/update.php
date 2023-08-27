<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Pasien */

$this->title = 'Update Pasien: ' . $model->mr;
$this->params['breadcrumbs'][] = ['label' => 'Pasiens', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->mr, 'url' => ['view', 'id' => $model->mr]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pasien-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
