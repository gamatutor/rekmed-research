<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tindakan */

$this->title = 'Update Tindakan: ' . $model->nama_tindakan;
$this->params['breadcrumbs'][] = ['label' => 'Tindakan', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nama_tindakan, 'url' => ['view', 'id' => $model->tindakan_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tindakan-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
