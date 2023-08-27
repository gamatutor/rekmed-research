<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use app\models\Pasien;
use app\models\Obat;
use app\models\Tindakan;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
use app\assets\DataTableAsset;
DataTableAsset::register($this);

$pasien = new Pasien();
$start_counter = isset($rm_obatracik) ? count($rm_obatracik) + 1 : 1;
/* @var $this yii\web\View */
/* @var $model app\models\RekamMedis */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
    Modal::begin([
            'id' => 'modal',
            'size'=>'modal-lg',
        ]);

    echo "<div id='modalContent'></div>";

    Modal::end();

?>

<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-red-sunglo">
                    <button class="btn btn-circle blue modalWindow" style="cursor: pointer;" value="<?= Url::to(['pasien/view','id'=>$kunjungan->mr0->mr]) ?>">Detail Pasien
                    </button>
                    <button class="btn btn-circle red modalWindow" style="cursor: pointer;" value="<?= Url::to(['pasien/diary-mobile','id'=>$kunjungan->mr0->mr]) ?>">Diary Pasien
                    </button>
                    <?php if(Yii::$app->user->identity->spesialis==28): ?>
                        <a class="btn btn-circle yellow" href="<?= Url::to(['rekam-medis/hplperbulan']) ?>">Pasien HPL Bulan ini</a>
                        <a class="btn btn-circle green" href="<?= Url::to(['rekam-medis/hplperminggu']) ?>">Pasien HPL Minggu ini</a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="portlet-body form">
                <table class="table table-bordered" style="width: 50%">
                    <tr>
                        <td>No. Rekam Medis</td>
                        <td><?= Html::encode($kunjungan->mr0->mr) ?></td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td><?= Html::encode($kunjungan->mr0->nama) ?></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td><?= Html::encode($kunjungan->mr0->alamat) ?></td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td><?= Html::encode($kunjungan->mr0->jk) ?></td>
                    </tr>
                    <tr>
                        <td>Umur</td>
                        <td><?= $pasien->getAge($kunjungan->mr0->tanggal_lahir) ?> Tahun</td>
                    </tr>
                </table>
                
                <div>
                <p>Histori Pemeriksaan : </p>
                    <ul class="pagination">
                        <?php 
                        if(!empty($histori_rm))
                        foreach($histori_rm as $val): ?>
                            <?php 
                            $time = strtotime($val['created']);
                            $myFormatForView = date("d F Y", $time);
                            if($val['rm_id']==$model->rm_id)
                            ?>
                            <li <?= $val['rm_id']==$model->rm_id ? 'class="active"' : "" ?>>
                                <a target="_blank" href="<?= Url::to(['rekam-medis/view','id'=>utf8_encode(Yii::$app->security->encryptByKey( $val['rm_id'], Yii::$app->params['kunciInggris'] ))]) ?>"> <?= $myFormatForView ?> </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <br/>
                    <?= Html::a('<i class="fa fa-bar-chart"></i> Riwayat RM', 
                            ['rekam-medis/index-by-mr','id'=>$model->mr],[
                            'class'=>'btn dark btn-sm btn-outline sbold uppercase',
                            'title' => Yii::t('yii', 'Riwayat RM'),
                            'target'=>'_blank',
                            'data-pjax' => '0',
                        ]);  ?>
                    <?= Html::button('<i class="fa fa-calendar-plus-o"></i> Kunjungan Selanjutnya', [
                            'value'=>Url::to(['pasien-next-visit/create','id'=>$model->mr]),
                            'class'=>'btn dark btn-sm btn-outline sbold uppercase modalWindow',
                            'title' => Yii::t('yii', 'Tambah Reminder'),
                            'data-pjax' => '0',
                        ]);  ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
//SPOG
if (Yii::$app->user->identity->spesialis==28)
    echo $this->render('_formTabSPOG', compact('model','histori_rm','rm_diagnosis_id','rm_diagnosis_text','rm_diagnosis_banding_id','rm_diagnosis_banding_text','rm_tindakan','rm_obat','rm_obatracik','rm_obatracik_komponen','kunjungan','data_exist'));
//ANAK
elseif (Yii::$app->user->identity->spesialis==3)
    echo $this->render('_formTabANAK', compact('model','histori_rm','rm_diagnosis_id','rm_diagnosis_text','rm_diagnosis_banding_id','rm_diagnosis_banding_text','rm_tindakan','rm_obat','rm_obatracik','rm_obatracik_komponen','kunjungan','data_exist'));
else
    echo $this->render('_formTabUmum', compact('model','histori_rm','rm_diagnosis_id','rm_diagnosis_text','rm_diagnosis_banding_id','rm_diagnosis_banding_text','rm_tindakan','rm_obat','rm_obatracik','rm_obatracik_komponen','kunjungan','data_exist'));
?>

    


<?php
$tombol_tambah = Html::button('<i class="fa fa-plus"></i> Obat Stok', ['value'=>Url::to(['obat/tambah-obat','tipe'=>'racik']),'class' => 'btn green-haze btn-outline sbold uppercase modalWindow']).' '.Html::button('<i class="fa fa-plus"></i> Obat Resep', ['type'=>'button','class'=>'btn green-haze btn-outline sbold uppercase tambah-resep-racik']);
$tombol_hapus = Html::button('<i class="fa fa-trash"></i> Hapus Racikan', ['class' => 'btn red-mint btn-outline sbold uppercase hapusRacikan']);
$script = <<< JS
    $(function(){
        var BMI = 0;
        function copas(){
            var str = 'TD = '+$('#rekammedis-tekanan_darah').val()+'mmHG; N = '+$('#rekammedis-nadi').val()+'/min; RR = '+$('#rekammedis-respirasi_rate').val()+'/min; BMI = '+BMI+';';
            // $("#rekammedis-pemeriksaan_fisik").redactor("code.set",str);
            $("#rekammedis-pemeriksaan_fisik").val(str);
        }
        
        $('.inputTglbaru').click(function(){
            var str = $("#pasien-alergi").redactor("code.get");
            var dt = '<p><b>['+new Date().toJSON().slice(0,10).split('-').reverse().join('/')+']</b>: </p>';
             $("#pasien-alergi").redactor("code.set", str+dt);
        });
        $('#rekammedis-keluhan_utama').parent().find('.redactor-editor').bind("DOMSubtreeModified",function(){
          $("#rekammedis-anamnesis").redactor("code.set",$(this).html());
        });

        $('.addToTemplate').click(function(){
            if($(".addToTemplate").is(':checked'))
                $(".templateName").show();  // checked
            else
                $(".templateName").hide();  // unchecked
        });
        $('#useDefault').click(function(){
            var t = $(this).is(':checked');
            $('.tekanan_darah').val('120/80');
            $('.nadi').val('80');
            $('.respirasi_rate').val('20');
            $('.suhu').val('36');

            $('.tekanan_darah').prop("readonly",t);
            $('.nadi').prop("readonly",t);
            $('.respirasi_rate').prop("readonly",t);
            $('.suhu').prop("readonly",t);
            copas();
        });
        // $( "#useDefault" ).trigger( "click" );


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
        
        function hitungBmi(){
            var bb = parseFloat($('#rekammedis-berat_badan').val());
            var tb = parseFloat($('#rekammedis-tinggi_badan').val());
            var bmi = bb / ((tb/100)*(tb/100));
            BMI = bmi.toFixed(1);
            $('#bmi_hasil').html(bmi.toFixed(2));
            copas();
        }
        hitungBmi();

        $('#rekammedis-berat_badan').keyup(function(){
            hitungBmi();
        })

        $('.delete-item').click(function(){
            $(this).parent().parent().remove()
        })

        $('#rekammedis-tinggi_badan').keyup(function(){
            hitungBmi();
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

        
        $('#adv').change(function(){
            if(document.getElementById('adv').checked) {
                $('.more_adv ').show()
                $('#tab_3').attr('style','')
                $('#tab_4').attr('style','')
                $('#tab_5').attr('style','')
            } else {
                $('.more_adv ').hide()
            }
        });
        $('.more_adv ').hide()

        $('.tambahRacikan').click(function(){
            racik_counter += 1;
            var str ='<div class="portlet light bordered"><div class="portlet-title"><div class="caption font-red-sunglo"><i class="icon-settings font-red-sunglo"></i><span class="caption-subject bold uppercase">Obat Racik</span></div></div><div class="portlet-body form"> {$tombol_tambah} <input type="hidden" value="'+racik_counter+'" /> {$tombol_hapus}<br/> <br/> <table class="table table-hover table-light"> <thead> <th>Nama Obat</th> <th>Jumlah</th> </thead> <tbody id="obat-rm-racik-'+racik_counter+'"> </tbody> </table> <div class="form-group"> <label class="control-label" for="pulf">M.F.Pulv No.</label> <input type="number" name="ObatRacik['+racik_counter+'][jumlah_pulf]" id="pulf" class="form-control"> </div> <div class="form-group"> <label class="control-label" for="signa_pulf">Signa</label> <input type="text" name="ObatRacik['+racik_counter+'][signa]" id="signa_pulf" class="form-control"> </div> </div> </div>';
            $('#rightCol').append(str);
            tambahResepRacik();
            $('.modalWindow').click(function(){
                $('#modal').modal('show')
                    .find('#modalContent')
                    .load($(this).attr('value')+"&counter="+racik_counter);
                    
            })
            $('.hapusRacikan').click(function(){
                $(this).parent().parent().remove();
            })
        });
        $('#rekammedis-tekanan_darah, #rekammedis-nadi, #rekammedis-respirasi_rate').keyup(function(){
            copas();
        })
        copas();

        //enable/disable farmasi by hash tab
        if(window.location.hash) {
            var advTab = ["#tab_5","#tab_3","#tab_4"];
            if(!document.getElementById("adv").checked && advTab.includes(window.location.hash))
                document.getElementById('adv').click();
        }
    });

JS;

$this->registerJs($script);
?>