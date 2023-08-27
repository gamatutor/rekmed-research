<?php
use yii\helpers\Html;

$this->title = "Kartu Pasien";
?>

<div class="row">
	<div class="col-md-6">
		<div class="portlet light bordered" id="blockui_sample_1_portlet_body">
		    <div class="portlet-title">
		        <div class="caption">
		            <span class="caption-subject sbold"><?= Html::encode($klinik->klinik_nama) ?></span>
		        </div>
		    </div>
		    <div class="portlet-body">
		    	<table class="table table-hover table-light">
		    		<tr>
			            <td style="widtd:20%"><strong>No. RM</strong></td>
			            <td>: <?= Html::encode($pasien->mr) ?></td>
			        </tr>
			        <tr>
			            <td><strong>Nama</strong></td>
			            <td>: <?= Html::encode($pasien->nama) ?></td>
			        </tr>
			        <tr>
			            <td><strong>Tanggal Lahir</strong></td>
			            <td>: <?= date("d-m-Y", strtotime($pasien->tanggal_lahir)) ?></td>
			        </tr>
			        <tr>
			            <td><strong>Alamat</strong></td>
			            <td>: <?= Html::encode($pasien->alamat) ?></td>
			        </tr>
			        

		    </table>
		    </div>
		</div>
	</div>
</div>

