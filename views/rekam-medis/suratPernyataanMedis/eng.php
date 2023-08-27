<?php use yii\helpers\Html; ?>
<table width="100%">
	<tr>
		<td align="center"><h2><?= Html::encode(strtoupper($klinik->klinik_nama)) ?></h2></td>
	</tr>
	<tr>
		<td align="center" height="60" valign="top"><?= Html::encode(ucfirst($klinik->alamat)) ?></td>
	</tr>
	<tr>
		<td height="40">Letter Number : <b><?= date("dmY-").$model->mr0->mr ?></b></td>
	</tr>
</table>


<h4 style="text-align:center"><center>MEDICAL STATEMENT LETTER</center></h4>
<br>
<strong>I hereby to certify</strong><br><br>
<p style="text-indent: 30px">
	<table width="100%">
		<tr>
			<td width="20%">Patient's Name</td>
			<td>: <?= $model->mr0->nama ?></td>
			<td>MR No. </td>
			<td>: <?= $model->mr0->mr ?></td>
		</tr>
		<tr>
			<td>DOB</td>
			<td colspan="3">: <?= date('d/m/Y', strtotime($model->mr0->tanggal_lahir)) ?></td>
		</tr>
		<tr>
			<td>Spouse Name</td>
			<td colspan="3">: __________________________________________________</td>
		</tr>
		<tr>
			<td>Address</td>
			<td colspan="3">: <?= $model->mr0->alamat ?></td>
		</tr>
	</table>
</p>
<br>
<br>
By the examination made on <?= date('d/m/Y', strtotime($model->created)) ?><br>
We found the patient is with<br><br>
<p style="text-indent: 30px">
	<table width="100%">
		<tr>
			<td>Diagnosis</td>
			<td colspan="3">: <?= $model->assesment ?></td>
		</tr>
		<tr>
			<td>LMP</td>
			<td colspan="3">: <?= date('d-m-Y',strtotime($model->spog_hpth)) ?></td>
		</tr>
		<tr>
			<td>EDD</td>
			<td colspan="3">: <?= date('d-m-Y',strtotime($model->spog_hpth. ' + 280 days')) ?></td>
		</tr>
	</table>
</p>
<br>
<br>
Thank you for your kind attention and cooperation<br><br>


<table  width="100%" style="margin-top: 50px">
	<tr>
		<td width="60%">
			<br/>
		</td>
		<td width="40%"  align="center">
			Best Regards,
			<br/>
			<br/>
			<br/>
			<br/>
			<strong>(<?= Html::encode(ucwords($dokter->nama)) ?>)</strong>
		</td>
	</tr>
</table>