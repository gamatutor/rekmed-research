<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Dokter */

$this->title = 'Update Dokter: ' . $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Dokters', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user_id, 'url' => ['view', 'id' => $model->user_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dokter-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
