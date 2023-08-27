

<?php foreach($data as $val): ?>

<div class="col-md-1 value"></div>
<div class="col-md-6 name"><?= $val['nama_tindakan'] ?></div>
<div class="col-md-5 value bayar_total">Rp <?= number_format($val['tarif_dokter']+$val['tarif_asisten'],0,'','.') ?></div>

<?php endforeach; ?>