<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
<h3>Cari Obat</h3>
<input type="text" id="cari-obat" placeholder="Ketik Nama Obat" class="form-control">
<br/>
<table class="table table-bordered">
	<thead>
		<tr>
			<th>Nama Merk</th>
			<th>Nama Generik</th>
			<th>Golongan</th>
			<th></th>
		</tr>
	</thead>
	<tbody id="hasil-obat">
		
	</tbody>
</table>


<?php
$urlCari = Url::to(['obat/cari-obat']);
$target_table = ($tipe=='biasa') ? 'obat-rm' : 'obat-rm-racik-'.$counter; 
$name_input = ($tipe=='biasa') ? 'Obat' : "ObatRacik[$counter]"; 
$str_signa = ($tipe=='biasa') ? 'yes': 'no' ; 
$script = <<< JS
    $(function(){
        $('#cari-obat').keyup(function(){
        	if($(this).val().length<2) {
        		$('#hasil-obat').html("");
        		return false;
        	}
            $.post('{$urlCari}',{keyword:$(this).val()})
	            .done(function(data){
	              data = JSON.parse(data);
	              str_hasil = ""
	              for(var i in data){
	                str_hasil += "<tr><td>"+data[i].nama_merk+"</td><td>"+data[i].nama_generik+"</td><td>"+data[i].golongan+"</td><td><button type='button' class='pilih-obat btn btn-primary' obat_id="+data[i].obat_id+" nama_merk='"+data[i].nama_merk+"'>Pilih</button>  </td></tr>"
	              }
	              $('#hasil-obat').html(str_hasil)
	              $('.pilih-obat').on('click',function(){
	                    obat_id = $(this).attr('obat_id')
	                    nama_merk = $(this).attr('nama_merk')
	                    str_obat = "<tr>";
	                    str_obat += "<td>"+nama_merk+"</td>";
	                    str_obat += "<td><input type='number' class='form-control' required placeholder='jumlah' name='{$name_input}[jumlah]["+obat_id+"]'></td>";
	                    if('{$str_signa}'=='yes')
	                    str_obat += "<td><input type='text' class='form-control' required placeholder='signa' name='{$name_input}[signa]["+obat_id+"]'></td>";
	                    str_obat += "<td><button type='button' class='btn btn-danger delete-item'>x</button></td>";
	                    str_obat += "</tr>";

	                    $('#{$target_table}').append(str_obat);

	                    $('.delete-item').click(function(){
				            $(this).parent().parent().remove()
				        })

				        $(this).parent().parent().remove()
	              })
	              
	            });
	        })
    });

JS;

$this->registerJs($script);
?>