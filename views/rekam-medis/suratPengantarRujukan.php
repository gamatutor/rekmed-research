<h4 style="text-align:center"><center>SURAT PENGANTAR RUJUKAN</center></h4>
<br>
<strong>Kepada Yth.</strong><br>
Di --<br><br>
Dengan Hormat,<br>
Mohon perawatan pasien sebagai berikut:<br>
<p style="text-indent: 30px">
	<table width="100%">
		<tr>
			<td>Nama</td>
			<td colspan="3">: <?= $model->mr0->nama ?></td>
		</tr>
		<tr>
			<td>Umur</td>
			<td>: <?= $model->mr0->getAge($model->mr0->tanggal_lahir) ?> Tahun</td>
			<td align="right"> DOB</td>
			<td>: <?= date('d/m/Y', strtotime($model->mr0->tanggal_lahir)) ?></td>
		</tr>
		<tr>
			<td>Alamat</td>
			<td colspan="3">: <?= $model->mr0->alamat ?></td>
		</tr>
	</table>
</p>
Dengan Diagnosis : <?= strip_tags($model->assesment) ?><br><br>
Rencana Tindakan : <br><br><br>
<strong><i>*Mohon Hubungi Dokter Bila Pasien Masuk</i></strong> <br>
Terimakasih<br>