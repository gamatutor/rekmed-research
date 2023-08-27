<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<center><h3><?= Html::encode($klinik->klinik_nama) ?></h3></center>
<center><p><?= Html::encode($klinik->alamat) ?></p></center>
<table class="table table-hover">
    <tr>
        <th>Tgl</th>
        <td><?= $model->created ?></td>
    </tr>
    <tr>
        <th>Dr.</th>
        <td><?= Html::encode($dokter->nama) ?></td>
    </tr>
</table>
<div class="row">
    <div class="col-md-12">
        <h4>Obat</h4>
        <table class="table table-striped table-hover">
            
            <tbody>
                <tbody>
                    <?php foreach($rm_obat as $value): ?>
                        <tr>
                            <td><?= Html::encode($value['nama_obat']) ?> <?= empty($value['obat_id']) ? ' (Resep)' : '' ?></td>
                            <td><?= Html::encode($value['jumlah']) ?></td>
                            <td><?= Html::encode($value['signa']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </tbody>
        </table>
        <?php foreach($rm_obatracik as $key=>$value): ?>
        <h4>Obat Racik #<?= $key+1 ?></h4>
        <table class="table table-striped table-hover">
            
            <tbody>
                <tbody>
                    <?php foreach($rm_obatracik_komponen[$value['racik_id']] as $val): ?>
                        <tr>
                            <td><?= Html::encode($val['nama_obat']) ?> <?= empty($val['obat_id']) ? ' (Resep)' : '' ?></td>
                            <td><?= $val['jumlah'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="2">M.F.Pulv : <?= $value['jumlah'] ?></td>
                    </tr>
                    <tr>
                        <td colspan="2">Signa : <?= Html::encode($value['signa']) ?></td>
                    </tr>
                </tbody>
            </tbody>
        </table>
        <?php endforeach; ?>
    </div>
</div>
<div class="row">
    <table class="table">
        <tr>
            <th>Pro</th>
            <td>: <?= Html::encode($pasien->nama) ?></td>
        </tr>
        <tr>
            <th>Umur</th>
            <td>: <?= !(empty($pasien->tanggal_lahir)) ? $pasien->getAge($pasien->tanggal_lahir) : 0 ?> Tahun</td>
        </tr>
        <tr>
            <th>Alamat</th>
            <td>: <?= Html::encode($pasien->alamat) ?></td>
        </tr>
        <tr>
            <th>No. RM</th>
            <td>: <?= Html::encode($pasien->mr) ?></td>
        </tr>

    </table>
</div>


        