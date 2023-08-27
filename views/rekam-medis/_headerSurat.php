<?php use yii\helpers\Html; ?>
<table width="100%">
	<tr>
		<td align="center"><h2><?= Html::encode(strtoupper($klinik->klinik_nama)) ?></h2></td>
	</tr>
	<tr>
		<td align="center" height="60" valign="top"><?= Html::encode(ucfirst($klinik->alamat)) ?></td>
	</tr>
	<tr>
		<td height="40">No. Surat : <b><?= date("dmY-").$model->mr0->mr ?></b></td>
	</tr>
</table>