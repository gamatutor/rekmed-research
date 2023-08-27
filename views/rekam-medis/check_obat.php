<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use app\models\Pasien;
$pasien = new Pasien();

$start_counter = isset($rm_obatracik) ? count($rm_obatracik) + 1 : 1;

?>

<?php $form = ActiveForm::begin(['id'=>'form-rm']); ?>

<?php
    Modal::begin([
            'id' => 'modal',
        ]);

    echo "<div id='modalContent'></div>";

    Modal::end();

?>
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-red-sunglo">
            <i class="icon-chemistry font-red-sunglo"></i>
            <span class="caption-subject bold uppercase">Pemeriksaan</span>
        </div>
    </div>
    <div class="portlet-body">
        <div class="row">
            <div class="col-md-3">
                <?= Html::encode($kunjungan->mr0->mr) ?>
                <br/>

                <strong><?= Html::encode($kunjungan->mr0->nama) ?></strong>
                <br/>

                <?= Html::encode($kunjungan->mr0->alamat) ?>
                <br/>

                <?= $kunjungan->mr0->jk ?>
                <br/>

                <?= $pasien->getAge($kunjungan->mr0->tanggal_lahir) ?> Tahun
            </div>
            <div class="col-md-9">
                <table class="table">
                    <tbody>
                        <tr>
                            <th style="width:20%">(S) Subyektif</th>
                            <td><?= $model->anamnesis ?></td>
                            <th>(O) Obyektif</th>
                            <td><?= $model->pemeriksaan_fisik ?></td>
                        </tr>
                        <tr>
                            <th>(A) Assesment</th>
                            <td><?= $model->pemeriksaan_fisik ?></td>
                            <th>(P) Plan</th>
                            <td><?= $model->plan ?></td>
                        </tr>
                        <tr>
                            <th>Alergi Obat</th>
                            <td colspan="3" style="color: red; font-weight: bolder"><?= $model->mr0->alergi ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-red-sunglo">
            <i class="icon-chemistry font-red-sunglo"></i>
            <span class="caption-subject bold uppercase">Obat</span>
        </div>
    </div>
    <div class="portlet-body form">
    <?= Html::button('<i class="fa fa-plus"></i> Obat Stok', ['value'=>Url::to(['obat/tambah-obat','tipe'=>'biasa']),'class' => 'btn green-haze btn-outline sbold uppercase modalWindow']) ?>
    <?= Html::button('<i class="fa fa-plus"></i> Obat Resep', ['type'=>'button','id'=>'tambah-resep','class' => 'btn green-haze btn-outline sbold uppercase']) ?>

    <br/>
    <br/>

    <table class="table table-hover table-light">
        <thead>
            <th>Nama Obat</th>
            <th>Jumlah</th>
            <th>Sinna</th>
        </thead>
        <tbody id="obat-rm">
            <?php if(isset($data_exist['Obat'])): ?>
            <?php foreach($data_exist['Obat']['jumlah'] as $obat_id => $jumlah): ?>
                <?php if($obat_id!='resep'): ?>
                <?php $obat = Obat::findOne(['obat_id'=>$obat_id]); ?> 
                <tr>
                    <td><?= $obat['nama_merk']  ?></td>
                    <td><input type="number" value="<?= $jumlah ?>" class="form-control" required="" placeholder="jumlah" name="Obat[jumlah][<?= $obat_id ?>]"></td>
                    <td><input type="text" value="<?= $data_exist['Obat']['signa'][$obat_id] ?>" class="form-control" required="" placeholder="signa" name="Obat[signa][<?= $obat_id ?>]"></td>
                    <td><button type="button" class="btn btn-danger delete-item">x</button></td>
                </tr>
                <?php endif; ?>
            <?php endforeach; ?>
            <?php endif; ?>

            <?php if(isset($rm_obat)): ?>
            <?php foreach($rm_obat as $key => $value): ?>
                <?php if(!empty($value['obat_id'])): ?>
                <tr>
                    <td><?= Html::encode($value['nama_obat'])  ?></td>
                    <td><input type="number" value="<?= $value['jumlah'] ?>" class="form-control" required="" placeholder="jumlah" name="Obat[jumlah][<?= $value['obat_id'] ?>]"></td>
                    <td><input type="text" value="<?= $value['signa'] ?>" class="form-control" required="" placeholder="signa" name="Obat[signa][<?= $value['obat_id'] ?>]"></td>
                    <td><button type="button" class="btn btn-danger delete-item">x</button></td>
                </tr>
                <?php else: ?>
                <tr>
                    <td><input value="<?= Html::encode($value['nama_obat']) ?>" type="text" class="form-control" required="" placeholder="Nama" name="Obat[nama][resep][]"></td>
                    <td><input type="number" value="<?= $value['jumlah'] ?>" class="form-control" required="" placeholder="jumlah" name="Obat[jumlah][resep][]"></td>
                    <td><input type="text" value="<?= Html::encode($value['signa']) ?>" class="form-control" required="" placeholder="signa" name="Obat[signa][resep][]"></td>
                    <td><button type="button" class="btn btn-danger delete-item">x</button></td>
                </tr>
                <?php endif; ?>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    </div>
</div>
<div id="rightCol">
<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-red-sunglo">
            <i class="icon-chemistry font-red-sunglo"></i>
            <span class="caption-subject bold uppercase">Obat Racik</span>
        </div>
    </div>
    <div class="portlet-body form">
        <?= Html::button('<i class="fa fa-plus"></i> Obat Stok', ['value'=>Url::to(['obat/tambah-obat','tipe'=>'racik']),'class' => 'btn green-haze btn-outline sbold uppercase modalWindow']) ?>
        <?= Html::button('<i class="fa fa-plus"></i> Obat Resep', ['type'=>'button','class' => 'btn green-haze btn-outline sbold uppercase tambah-resep-racik','counter'=>1]) ?>
        <input type="hidden" value="1" />
        <?= Html::button('<i class="fa fa-plus"></i> Racikan', ['class' => 'btn purple-sharp btn-outline sbold uppercase tambahRacikan']) ?>
        
        <br/>
        <br/>
        <table class="table table-hover table-light">
            <thead>
                <th>Nama Obat</th>
                <th>Jumlah</th>
            </thead>
            <tbody id="obat-rm-racik-1">
                <?php if(isset($rm_obatracik[0])): ?>
                <?php if(isset($rm_obatracik_komponen[$rm_obatracik[0]['racik_id']])): ?>
                <?php foreach($rm_obatracik_komponen[$rm_obatracik[0]['racik_id']] as $key => $value): ?>
                    <?php if(!empty($value['obat_id'])): ?>
                    <tr>
                        <td><?= Html::encode($value['nama_obat'])  ?></td>
                        <td><input type="number" value="<?= $value['jumlah'] ?>" class="form-control" required="" placeholder="jumlah" name="ObatRacik[1][jumlah][<?= $value['obat_id'] ?>]"></td>
                        <td><button type="button" class="btn btn-danger delete-item">x</button></td>
                    </tr>
                    <?php else: ?>
                    <tr>
                        <td><input value="<?= Html::encode($value['nama_obat']) ?>" type="text" class="form-control" required="" placeholder="Nama" name="ObatRacik[1][nama][resep][]"></td>
                        <td><input type="number" value="<?= $value['jumlah'] ?>" class="form-control" required="" placeholder="jumlah" name="ObatRacik[1][jumlah][resep][]"></td>
                        <td><button type="button" class="btn btn-danger delete-item">x</button></td>
                    </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?php endif; ?>
                <?php endif; ?>
            </tbody>

        </table>

        <div class="form-group">
            <label class="control-label" for="pulf">M.F.Pulv No.</label>
            <input type="number" name="ObatRacik[1][jumlah_pulf]" value="<?= isset($rm_obatracik[0]['jumlah']) ? $rm_obatracik[0]['jumlah'] : "" ?>" id="pulf" class="form-control">
        </div>
        <div class="form-group">
            <label class="control-label" for="signa_pulf">Signa</label>
            <input type="text" name="ObatRacik[1][signa]" value="<?= isset($rm_obatracik[0]['signa']) ? $rm_obatracik[0]['signa'] : "" ?>" id="signa_pulf" class="form-control">
        </div>
        
    </div>
</div>

<?php if(isset($rm_obatracik)): ?>
<?php if(count($rm_obatracik)>1): ?>
<?php foreach($rm_obatracik as $key_racik=>$value_racik): ?>
<?php if($key_racik==0) continue; ?>
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption font-red-sunglo">
                <i class="icon-settings font-red-sunglo"></i>
                <span class="caption-subject bold uppercase">Obat Racik</span>
            </div>
        </div>
        <div class="portlet-body form">
            <?= Html::button('<i class="fa fa-plus"></i> Obat Stok', ['value'=>Url::to(['obat/tambah-obat','tipe'=>'racik']),'class' => 'btn green-haze btn-outline sbold uppercase modalWindow']).' '.Html::button('<i class="fa fa-plus"></i> Obat Resep', ['type'=>'button','class'=>'btn green-haze btn-outline sbold uppercase tambah-resep-racik','counter'=>$key_racik+2]) ?>
            <input type="hidden" value="1" />
            <?= Html::button('<i class="fa fa-trash"></i> Hapus Racikan', ['class' => 'btn red-mint btn-outline sbold uppercase hapusRacikan']) ?>
            
            <br/>
            <br/>
            <table class="table table-hover table-light">
                <thead>
                    <th>Nama Obat</th>
                    <th>Jumlah</th>
                </thead>
                <tbody id="obat-rm-racik-1">
                    <?php if(isset($rm_obatracik_komponen[$value_racik['racik_id']])): ?>
                    <?php foreach($rm_obatracik_komponen[$value_racik['racik_id']] as $key => $value): ?>
                        <?php if(!empty($value['obat_id'])): ?>
                        <tr>
                            <td><?= Html::encode($value['nama_obat'])  ?></td>
                            <td><input type="number" value="<?= $value['jumlah'] ?>" class="form-control" required="" placeholder="jumlah" name="ObatRacik[<?= $key_racik+2 ?>][jumlah][<?= $value['obat_id'] ?>]"></td>
                            <td><button type="button" class="btn btn-danger delete-item">x</button></td>
                        </tr>
                        <?php else: ?>
                        <tr>
                            <td><input value="<?= Html::encode($value['nama_obat']) ?>" type="text" class="form-control" required="" placeholder="Nama" name="ObatRacik[<?= $key_racik+2 ?>][nama][resep][]"></td>
                            <td><input type="number" value="<?= $value['jumlah'] ?>" class="form-control" required="" placeholder="jumlah" name="ObatRacik[<?= $key_racik+2 ?>][jumlah][resep][]"></td>
                            <td><button type="button" class="btn btn-danger delete-item">x</button></td>
                        </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>

            </table>

            <div class="form-group">
                <label class="control-label" for="pulf">M.F.Pulv No.</label>
                <input type="number" name="ObatRacik[<?= $key_racik+2 ?>][jumlah_pulf]" value="<?= isset($value_racik['jumlah']) ? $value_racik['jumlah'] : "" ?>" id="pulf" class="form-control">
            </div>
            <div class="form-group">
                <label class="control-label" for="signa_pulf">Signa</label>
                <input type="text" name="ObatRacik[<?= $key_racik+2 ?>][signa]" value="<?= isset($value_racik['signa']) ? $value_racik['signa'] : "" ?>" id="signa_pulf" class="form-control">
            </div>

        </div>
    </div>
<?php endforeach; ?>
<?php endif; ?>
<?php endif; ?>
</div>
<?= Html::submitButton('Simpan', ['id'=>'simpan_submit','class' => 'btn blue','name'=>'Simpan']) ?>
<?= Html::submitButton('Simpan & Selesai', ['id'=>'selesai_submit','class' => 'btn red','name'=>'Selesai']) ?>
<?php ActiveForm::end(); ?>



<?php

$tombol_tambah = Html::button('<i class="fa fa-plus"></i> Obat Stok', ['value'=>Url::to(['obat/tambah-obat','tipe'=>'racik']),'class' => 'btn green-haze btn-outline sbold uppercase modalWindow']).' '.Html::button('<i class="fa fa-plus"></i> Obat Resep', ['type'=>'button','class'=>'btn green-haze btn-outline sbold uppercase tambah-resep-racik']);
$tombol_hapus = Html::button('<i class="fa fa-trash"></i> Hapus Racikan', ['class' => 'btn red-mint btn-outline sbold uppercase hapusRacikan']);

$script = <<< JS
    $(function(){
        $('#form-rm button:submit').click(function() {
            $('#form-rm').submit();
            $(this).attr('disabled', true);
        });

        $('#tambah-resep').click(function(){
            str_obat = "<tr>";
            str_obat += "<td><input type='text' class='form-control' required placeholder='Nama' name='Obat[nama][resep][]'></td>";
            str_obat += "<td><input type='number' class='form-control' required placeholder='jumlah' name='Obat[jumlah][resep][]'></td>";
            str_obat += "<td><input type='text' class='form-control' required placeholder='signa' name='Obat[signa][resep][]'></td>";
            str_obat += "<td><button type='button' class='btn btn-danger delete-item'>x</button></td>";
            str_obat += "</tr>";

            $('#obat-rm').append(str_obat);

            $('.delete-item').click(function(){
                $(this).parent().parent().remove()
            })
        })
        tambahResepRacik();
        function tambahResepRacik(){
            $('.tambah-resep-racik').click(function(){
                var c = $(this).attr('counter')
                str_obat = "<tr>";
                str_obat += "<td><input type='text' class='form-control' required placeholder='Nama' name='ObatRacik["+c+"][nama][resep][]'></td>";
                str_obat += "<td><input type='number' class='form-control' required placeholder='jumlah' name='ObatRacik["+c+"][jumlah][resep][]'></td>";
                str_obat += "<td><button type='button' class='btn btn-danger delete-item'>x</button></td>";
                str_obat += "</tr>";
                $(this).parent().find('table').append(str_obat);

                $('.delete-item').click(function(){
                    $(this).parent().parent().remove()
                })
            })
        }
        $('.delete-item').click(function(){
            $(this).parent().parent().remove()
        })

        var racik_counter = {$start_counter};
        $('.modalWindow').click(function(){
            $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value')+"&counter="+racik_counter)
        })
        $('.hapusRacikan').click(function(){
            $(this).parent().parent().remove();
        })

        
        $('.tambahRacikan').click(function(){
            racik_counter += 1;
            var str ='<div class="portlet light bordered"><div class="portlet-title"><div class="caption font-red-sunglo"><i class="icon-chemistry font-red-sunglo"></i><span class="caption-subject bold uppercase">Obat Racik</span></div></div><div class="portlet-body form"> {$tombol_tambah} <input type="hidden" value="'+racik_counter+'" /> {$tombol_hapus}<br/> <br/> <table class="table table-hover table-light"> <thead> <th>Nama Obat</th> <th>Jumlah</th> </thead> <tbody id="obat-rm-racik-'+racik_counter+'"> </tbody> </table> <div class="form-group"> <label class="control-label" for="pulf">M.F.Pulv No.</label> <input type="number" name="ObatRacik['+racik_counter+'][jumlah_pulf]" id="pulf" class="form-control"> </div> <div class="form-group"> <label class="control-label" for="signa_pulf">Signa</label> <input type="text" name="ObatRacik['+racik_counter+'][signa]" id="signa_pulf" class="form-control"> </div> </div> </div>';
            $('#rightCol').append(str);
            tambahResepRacik();
            $('.modalWindow').click(function(){
                $('#modal').modal('show')
                    .find('#modalContent')
                    .load($(this).attr('value')+"&counter="+racik_counter)
            })
            $('.hapusRacikan').click(function(){
                $(this).parent().parent().remove();
            })
        })

        $('#form-rm button:submit').click(function() {
            $(this).attr('disabled', true);

            $('#form-rm').yiiActiveForm('validate');
            $('#form-rm').yiiActiveForm('submitForm');
        });
    });

JS;

$this->registerJs($script);


?>