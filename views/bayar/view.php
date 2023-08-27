<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Bayar */

$this->title = $model->no_invoice;
$this->params['breadcrumbs'][] = ['label' => 'Bayars', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bayar-view">

    <h3>Detail Pembayaran</h3>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'no_invoice',
            'mr',
            'nama_pasien',
            'alamat',
            'tanggal_bayar',
            'subtotal:decimal',
            'diskon:decimal',
            'total:decimal',
            'kembali:decimal',
            'bayar:decimal',
            //'created',
        ],
    ]) ?>

    <h3>Obat</h3>
    <table class="table table-striped table-hover">
        <tbody>
            <?php foreach($obat as $val): ?>
            <tr>
                <th><?= Html::encode($val['nama_obat']) ?></th>
                <td>Rp <?= number_format($val['harga_satuan'],0,'','.') ?></td>
                <td>x <?= number_format($val['jumlah'],0,'','.') ?></td>
                <td>= Rp <?= number_format($val['harga_total'],0,'','.') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Tindakan</h3>
    <table class="table table-striped table-hover">
        <tbody>
            <?php foreach($tindakan as $val): ?>
            <tr>
                <th><?= $val['nama_tindakan'] ?></th>
                <td>Rp <?= number_format($val['harga'],0,'','.') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <p style="text-align:right">
        <?= Html::a('Batalkan Pembayaran', ['delete', 'id' => $model->no_invoice, 'asal' => $asal], [
            'class' => 'btn red-mint btn-outline sbold uppercase',
            'data' => [
                'confirm' => 'Apakah Anda Yakin akan Membatalkan Pembayaran?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
</div>
