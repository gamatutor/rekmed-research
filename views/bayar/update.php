<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Bayar */

$this->title = 'Update Bayar: ' . $model->no_invoice;
$this->params['breadcrumbs'][] = ['label' => 'Bayars', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->no_invoice, 'url' => ['view', 'id' => $model->no_invoice]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="bayar-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
