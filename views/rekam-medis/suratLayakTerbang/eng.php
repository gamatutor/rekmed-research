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


<h4 style="text-align:center"><center>TO WHOM IT MAY CONCERN</center></h4>
<br>
<p style="text-indent: 30px">
	<table width="100%">
		<tr>
			<td rowspan="3" valign="top" width="5%"><strong>Re:</strong></td>
			<td width="20%">Patient's Name</td>
			<td>: <?= $model->mr0->nama ?></td>
			<td>MR No. </td>
			<td>: <?= $model->mr0->mr ?></td>
		</tr>
		<tr>
			<td>DOB</td>
			<td colspan="3">: <?= date('d/m/Y', strtotime($model->mr0->tanggal_lahir)) ?>(DD/MM/YYYY)</td>
		</tr>
		<tr>
			<td>EDD</td>
			<td colspan="3">: ____/____/________(DD/MM/YYYY)<br>   <i>EDD: Estimated Date of Delivery</i></td>
		</tr>
	</table>
</p>
<br>
Proposed dates of air travel
<table border="1" width="100%" style="border-collapse: collapse;">
	<tr>
		<td>Date</td>
		<td>Flight No.</td>
		<td>From.</td>
		<td>To.</td>
		<td>Status</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
</table>

<br>
Additional Remarks: _____________________________________________________________________<br>
In my medical opinion this person has:<br>
&#10063; An uncomplicated single pregnancy of ____________ weeks gestation or<br>
&#10063; A multiple/ complicated pregnancy of ____________ weeks gestation and<br>
is <strong>"Fit to Travel"</strong> for the time covering the entire journey with no intended/ voluntary stopover at the transit point with your airline.
<br>
<br>
<table  width="100%" style="margin-top: 50px">
	<tr>
		<td width="60%">
			<br/>
		</td>
		<td width="40%"  align="center">
			Yours Sincerely,
			<br/>
			<br/>
			<br/>
			<br/>
			<strong>(<?= Html::encode(ucwords($dokter->nama)) ?>)</strong>
		</td>
	</tr>
</table>