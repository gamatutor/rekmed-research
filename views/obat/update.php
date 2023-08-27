<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Obat */

$this->params['breadcrumbs'][] = ['label' => 'Obat', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nama_merk, 'url' => ['view', 'id' => $model->obat_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="obat-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
