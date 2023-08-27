<?php use yii\helpers\Html; ?>
<table width="100%">
	<tr>
		<td align="center"><h2><?= Html::encode(strtoupper($klinik->klinik_nama)) ?></h2></td>
	</tr>
	<tr>
		<td align="center" height="60" valign="top"><?= Html::encode(ucfirst($klinik->alamat)) ?></td>
	</tr>
	<tr>
		<td height="40">No. Surat Rujukan : <b><?= date("dmY-").$model->mr0->mr ?></b></td>
	</tr>
</table>
<table width="100%">
	<tr>
		<td width="60%"></td>
		<td align="right" width="40%">__________, <?= date("d F Y") ?></td>
	</tr>
	<tr>
		<td width="60%"></td>
		<td align="center" width="40%">Kepada : <br/>__________________________<br>__________</td>
	</tr>
</table>
<br/>

Dengan Hormat, <br/>
Bersama ini kami mohon pemeriksaan dan penanganan lebih lanjut atas penderita:
<table style="margin-left: 20px">
	<tr>
		<td>Nama</td>
		<td>:</td>
		<td><?= Html::encode($model->mr0->nama) ?></td>
	</tr>
	<tr>
		<td>Usia</td>
		<td>:</td>
		<td><?= $model->mr0->getAge($model->mr0->tanggal_lahir) ?> Tahun</td>
	</tr>
	<tr>
		<td>Alamat</td>
		<td>:</td>
		<td><?= Html::encode($model->mr0->alamat) ?></td>
	</tr>
	<tr>
		<td>Hasil Pemeriksaan</td>
		<td>:</td>
		<td><?= $model->anamnesis ?>, <?= $model->pemeriksaan_fisik ?></td>
	</tr>
	<tr>
		<td>Diagnosis</td>
		<td>:</td>
		<td><?= $model->assesment ?></td>
	</tr>
	<tr>
		<td>Terapi Sementara</td>
		<td>:</td>
		<td><sttrong><?= $model->plan ?></sttrong></td>
	</tr>
</table>

Atas penanganan dan penerimaannya kami sampaikan banyak terimakasih.

<table  width="100%" style="margin-top: 50px">
	<tr>
		<td width="60%">
			<br/>
		</td>
		<td width="40%"  align="center">
			Tertanda,
			<br/>
			<br/>
			<br/>
			<br/>
			<strong>(<?= Html::encode(ucwords($dokter->nama)) ?>)</strong>
		</td>
	</tr>
</table>