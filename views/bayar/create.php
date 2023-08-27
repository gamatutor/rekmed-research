<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Bayar */

$this->title = 'Bayar';
$this->params['breadcrumbs'][] = ['label' => 'Bayars', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bayar-create">

    <?= $this->render('_form', compact('model','obat','obat_racik','tindakan','kunjungan')) ?>

</div>
