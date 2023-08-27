<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Obat */

$this->title = $model->nama_merk;
$this->params['breadcrumbs'][] = ['label' => 'Obat', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="obat-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nama_merk',
            'pabrikan',
            'nama_generik',
            'golongan',
            'dosis',
            'kemasan',
            'tanggal_beli',
            'tanggal_kadaluarsa',
            'harga_beli',
            'harga_jual',
            'stok',
            'created',
            //'modified',
        ],
    ]) ?>

</div>
