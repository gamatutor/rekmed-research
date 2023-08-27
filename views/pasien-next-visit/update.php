<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PasienNextVisit */

$this->title = 'Update Pasien Next Visit: ' . $model->pasien_schedule_id;
$this->params['breadcrumbs'][] = ['label' => 'Pasien Next Visits', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->pasien_schedule_id, 'url' => ['view', 'id' => $model->pasien_schedule_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pasien-next-visit-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
