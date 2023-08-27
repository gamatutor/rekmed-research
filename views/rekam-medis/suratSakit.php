<?php use yii\helpers\Html; ?>
<table width="100%">
	<tr>
		<td align="center"><h2><?= strtoupper($klinik->klinik_nama) ?></h2></td>
	</tr>
	<tr>
		<td align="center" height="60" valign="top"><?= Html::encode(ucfirst($klinik->alamat)) ?></td>
	</tr>
	<tr>
		<td height="40">No. Surat Keterangan Sakit : <b><?= date("dmY-").$model->mr0->mr ?></b></td>
	</tr>
	<tr>
		<td align="center"><center><b><u>SURAT KETERANGAN SAKIT</u></b></center></h3></td>
	</tr>
</table>
<br/>

Saya yang bertandatangan dibawah ini menerangkan bahwa:
<table style="margin-left: 20px">
	<tr>
		<td>Nama</td>
		<td>:</td>
		<td><?= Html::encode($model->mr0->nama) ?></td>
	</tr>
	<tr>
		<td>Jenis Kelamin</td>
		<td>:</td>
		<td><?= $model->mr0->jk ?></td>
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
		<td>Pekerjaan</td>
		<td>:</td>
		<td><?= Html::encode($model->mr0->pekerjaan) ?></td>
	</tr>
</table>

Berdasarkan hasil anamnesis atau pemeriksaan yang kami lakukan, pasien tersebut memerlukan istirahat selama ___ Hari, dari tanggal ______________ s/d ______________.
<br/>
Demikian surat keterangan ini diberikan untuk diketahui dan digunakan sebagaimana mestinya.

<table  width="100%" style="margin-top: 50px">
	<tr>
		<td width="60%">
			Diagnosis Pasien adalah:_______________<br/>
			Diagnosis tersebut ditulis telah seijin pasien
		</td>
		<td width="40%"  align="center">
			__________, <?= date("d F Y") ?> 
			<br/>
			<br/>
			<br/>
			<br/>
			<strong>(<?= Html::encode(ucwords($dokter->nama)) ?>)</strong>
		</td>
	</tr>
</table>