<h4 style="text-align:center"><center>SURAT KETERANGAN DIAGNOSIS</center></h4>
<br>
<strong>Yang bertanda tangan dibawah ini menerangkan bahwa:</strong><br>
<p style="text-indent: 10px">
	<table width="100%">
		<tr>
			<td>Nama Ibu</td>
			<td>: <?= $model->mr0->nama ?></td>
			<td>No. RM</td>
			<td>: <?= $model->mr0->mr ?></td>
		</tr>
		<tr>
			<td>Suami</td>
			<td colspan="3">: _______________________________________</td>
		</tr>
		<tr>
			<td>Tanggal Lahir</td>
			<td>: <?= date('d-m-Y', strtotime($model->mr0->tanggal_lahir)) ?></td>
			<td> Umur :</td>
			<td><?= $model->mr0->getAge($model->mr0->tanggal_lahir) ?> Tahun</td>
		</tr>
		<tr>
			<td>Alamat</td>
			<td colspan="3">: <?= $model->mr0->alamat ?></td>
	</table>
</p>
Pada pemeriksaan yang dilakukan pada tanggal <?= date('d-m-Y', strtotime($model->created)) ?> didapatkan dengan:<br><br>
Diagnosis : <?= strip_tags($model->assesment) ?><br><br><br>
HT : <br>
HP : <br><br><br>
<strong>Saat ini ibu dan bayi dalam keadaan </strong>_________________________________ <br>
Demikian surat keterangan ini dibuat agar dapat dipergunakan sebagaimana mestinya<br>