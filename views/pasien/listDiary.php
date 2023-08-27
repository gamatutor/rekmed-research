<?php
use app\assets\DataTableAsset;
DataTableAsset::register($this);
?>
<h2>Daftar Diary Pasien</h2>
<p style="margin-top: 100px">
	<table class="table" id="myTable">
		<thead>
				<td>Riwayat medis</td>
				<td>Keterangan</td>
		<!--	<td>Lampiran</td> -->
				<td>Waktu entri</td>
		</thead>
		<tbody>
			<?php foreach ($data as $key => $value): ?>
				<tr>
					<td><? echo $value->title; ?></td>
					<td><? echo $value->content; ?></td>
					<td><?= date('d-M-Y H:i:s', strtotime($value->updated_at)) ?></td>
				</tr>
			<?php endForeach; ?>
		</tbody>
	</table>
</p>
<?php
$script = <<< JS
    $('#myTable').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
JS;

$this->registerJs($script);
        
// $this->registerJsFile('//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>