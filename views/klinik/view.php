<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Klinik */

$this->title = $model->klinik_nama;
$this->params['breadcrumbs'][] = ['label' => 'Klinik', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="klinik-view">
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->klinik_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Reset RM', ['clear-rm', 'id' => $model->klinik_id], [
            'class' => 'btn btn-warning',
            'data' => [
                'confirm' => 'Anda yakin ingin menghapus seluruh data RM dari klinik '.$model->klinik_nama.'?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->klinik_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'klinik_id',
            'klinik_nama',
            'alamat:ntext',
            'nomor_telp_1',
            'nomor_telp_2',
            'kepala_klinik',
            'maximum_row',
            'rmSekarang'
        ],
    ]) ?>

</div>
<div>
    <h3>Dokter Terdaftar</h3><hr>
    <table class="table table-bordered">
        <thead>
            <th>Nama Dokter</th>
            <th>Spesialis</th>
            <th>Jumlah RM</th>
            <th>Download</th>
        </thead>
        <tbody>
            <?php foreach ($model->users as $key => $value)
                if(isset($value->dokter)): ?>
                <tr>
                    <td><?= $value->dokter->nama ?></td>
                    <td><?= $value->dokter->spesialisasi->nama ?></td>
                    <td><?= count($value->dokter->rms) ?></td>
                    <td>
                        <?= Html::a('Rekam Medis*', ['dokter/dl-rm','dokter'=>$value->dokter->user_id], ['class'=>'btn btn-primary']) ?>
                        <?= Html::a('Template SOAP', ['dokter/dl-template-soap','dokter'=>$value->dokter->user_id], ['class'=>'btn btn-primary']) ?>
                    </td>
                </tr>
            <?php endIf ?>
        </tbody>
    </table>
</div>