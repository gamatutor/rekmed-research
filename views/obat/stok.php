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

    <h3><?= Html::encode($this->title) ?></h3>

    <table class="table table-bordered">
        <thead>
            <th>Tanggal Stok</th>
            <th>Tipe</th>
            <th>Jenis</th>
            <th>Jumlah</th>
            <th>Keterangan</th>
            <th>Stok Sebelum</th>
        </thead>
        <tbody>
            <?php foreach($stok as $value): ?>
            <td><?= Html::encode($value['tanggal_stok']) ?></td>
            <td><?= Html::encode($value['tipe']) ?></td>
            <td><?= Html::encode($value['jenis']) ?></td>
            <td><?= Html::encode($value['jumlah']) ?></td>
            <td><?= Html::encode($value['keterangan']) ?></td>
            <td><?= Html::encode($value['stok_sebelum']) ?></td>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>
