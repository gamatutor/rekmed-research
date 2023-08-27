<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Kunjungan */

$this->title = 'Update Kunjungan: ' . $model->kunjungan_id;
$this->params['breadcrumbs'][] = ['label' => 'Kunjungans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->kunjungan_id, 'url' => ['view', 'id' => $model->kunjungan_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="kunjungan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
