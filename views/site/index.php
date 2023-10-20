<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use miloschuman\highcharts\Highcharts;

/* @var $this yii\web\View */

$this->title = 'Rekam Medis';
?>
<?php
    Modal::begin([
            'header' => '<h4>Pasien</h4>',
            'options' => [
                'id' => 'kartik-modal',
                'tabindex' => false // important for Select2 to work properly
            ],
        ]);

    echo "<div id='modalContent'></div>";

    Modal::end();

?>
<?php if($full): ?>
<div class="alert alert-block alert-danger fade in">
    <h4 class="alert-heading">Rekam Medis Penuh!</h4>
    <p> Hubungi Administrator untuk menambah kapasitass RM </p>
    <br/>
    <p>
        <a class="btn red" href="javascript:;"> Hubungi </a>
    </p>
</div>
<?php endif; ?>
<?php if(!$complete_profile): ?>
<div class="alert alert-block alert-danger fade in">
    <h4 class="alert-heading">Lengkapi Profil Dokter!</h4>
    <p> Harap Lengkapi Profil Dokter </p>
    <br/>
    <p>
        <?= Html::a('Lengkapi',Url::to(['dokter/update','id'=>Yii::$app->user->identity->id]),['class'=>'btn red']) ?>
        <?= Html::a('Bantuan',Url::to(['site/bantuan']),['class'=>'btn blue']) ?>
    </p>
</div>
<?php endif; ?>
<div class="row">
    <div class="col-md-6 col-sm-6">
        <div class="portlet light bordered">
        <h4 <?= $sisa<=10? 'style="font-weight: bold; color: red;"':"" ?>>Sisa Deposit RM anda : <?= $sisa ?> <?= $sisa<=10? ", Segera lakukan TOPUP RM.":"" ?></h4>
            <div class="portlet-title">
                <div class="caption caption-md">
                    <i class="icon-bar-chart font-red"></i>
                    <span class="caption-subject font-red bold uppercase">Antrian Pemeriksaan</span>
                    <span class="caption-helper"></span>
                </div>
               
                <div class="actions">
                     <?= Html::a('<i class="fa fa-plus"></i> Janjian', Url::to(['pasien/index']),['class' => 'btn btn-circle btn-primary']) ?>
                    <div class="btn-group btn-group-devided" data-toggle="buttons">
                        
                        <?= Html::button('<i class="fa fa-plus"></i> Pasien Lama', ['value'=>Url::to(['kunjungan/create','asal'=>'site/index']),'class' => 'btn btn-circle green modalWindow']) ?>
                        <?= Html::button('<i class="fa fa-plus"></i> Pasien Baru', ['value'=>Url::to(['pasien/create','asal'=>'site/index']),'class' => 'btn btn-circle red-sunglo modalWindow']) ?>
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-scrollable table-scrollable-borderless">
                    <table class="table table-hover table-light">
                        <thead>
                            <th>Antrian</th>
                            <th>MR</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </thead>
                        <tbody>
                            <?php foreach($kunjungan as $val): ?>
                                <tr>
                                    <td><?php if($val['nomor_antrian']>0)
                                            echo Html::encode($val['nomor_antrian']);
                                        else
                                            echo '-'; ?></td>
                                    <td><?= Html::encode($val['mr']) ?></td>
                                    <td><?= Html::encode($val['mr0']['nama']) ?></td>
                                    <td><?= Html::encode($val['mr0']['alamat']) ?></td>
                                    <td>
                                        <?= 
                                        $val['status'] == 'antri' ?
                                        Html::a('<span class="fa fa-stethoscope"></span> Proses', Url::to(['rekam-medis/create','kunjungan_id'=>utf8_encode(Yii::$app->security->encryptByKey( $val['kunjungan_id'], Yii::$app->params['kunciInggris'] ))]), [
                                                'title' => Yii::t('yii', 'Proses'),
                                                'class' => 'btn dark btn-sm btn-outline sbold uppercase',
                                            ]) : 
                                        Html::a('<span class="fa fa-stethoscope"></span> Proses', Url::to(['rekam-medis/update','id'=>utf8_encode(Yii::$app->security->encryptByKey( $val['rekamMedis'][0]['rm_id'], Yii::$app->params['kunciInggris'] ))]), [
                                                'title' => Yii::t('yii', 'Proses'),
                                                'class' => 'btn dark btn-sm btn-outline sbold uppercase',
                                            ]);
                                        ?>
                                        <?php
                                        if($val['status'] == 'antri')
                                            echo Html::a('<span class="fa fa-trash-o"></span>',Url::to(['kunjungan/delete','id'=>$val['kunjungan_id']]), [
                                                    'class' => 'btn btn-default',
                                                    'title' => Yii::t('yii', 'Hapus'),
                                                    'data-confirm' => Yii::t('yii', 'Apakah Anda Yakin akan menghapus antrian ini?'),
                                                    'data-method' => 'post',
                                                    'data-pjax' => '0',
                                                ]);  
                                                ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php if(Yii::$app->user->identity->spesialis==28): ?>
                        <a class="btn btn-circle yellow" href="<?= Url::to(['rekam-medis/hplperbulan']) ?>">Pasien HPL Bulan ini</a>
                        <a class="btn btn-circle green" href="<?= Url::to(['rekam-medis/hplperminggu']) ?>">Pasien HPL Minggu ini</a>
                    <?php endif; ?>
        </div>
    </div>
    <div class="col-md-6 col-sm-6">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption caption-md">
                    <i class="icon-bar-chart font-blue"></i>
                    <span class="caption-subject font-blue bold uppercase">Antrian Farmasi</span>
                    <span class="caption-helper"></span>
                </div>
                
            </div>
            <div class="portlet-body">
                <div class="table-scrollable table-scrollable-borderless">
                    <table class="table table-hover table-light">
                        <thead>
                            <th>MR</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </thead>
                        <tbody>
                            <?php foreach($farmasi as $val): ?>
                                <tr>
                                    <td><?= Html::encode($val['mr']) ?></td>
                                    <td><?= Html::encode($val['mr0']['nama']) ?></td>
                                    <td><?= Html::encode($val['mr0']['alamat']) ?></td>
                                    <td>
                                        <?= Html::a(
                                            'Resep',
                                            Url::to(['rekam-medis/check-obat','kunjungan_id'=>utf8_encode(Yii::$app->security->encryptByKey( $val['kunjungan_id'], Yii::$app->params['kunciInggris'] )),'asal'=>'site/index']),
                                            ['class'=>'btn dark btn-sm btn-outline sbold uppercase',
                                                'title' => Yii::t('yii', 'Lihat')]
                                            ) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-sm-6">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption caption-md">
                    <i class="icon-bar-chart font-green"></i>
                    <span class="caption-subject font-green bold uppercase">Antrian Pembayaran</span>
                    <span class="caption-helper"></span>
                </div>
                
            </div>
            <div class="portlet-body">
                <div class="table-scrollable table-scrollable-borderless">
                    <table class="table table-hover table-light">
                        <thead>
                            <th>MR</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </thead>
                        <tbody>
                            <?php foreach($pembayaran as $val): ?>
                                <tr>
                                    <td><?= Html::encode($val['mr']) ?></td>
                                    <td><?= Html::encode($val['mr0']['nama']) ?></td>
                                    <td><?= Html::encode($val['mr0']['alamat']) ?></td>
                                    <td>

                                        <?php 
                                        echo Html::button('Bayar', ['value'=>Url::to(['bayar/create','id'=>utf8_encode(Yii::$app->security->encryptByKey( $val['kunjungan_id'], Yii::$app->params['kunciInggris'] )),'asal'=>'site/index']),'class' => 'btn dark btn-sm btn-outline sbold uppercase modalWindow']);
                                        // echo Html::a('Bayar', Url::to(['bayar/create','id'=>utf8_encode(Yii::$app->security->encryptByKey( $val['kunjungan_id'], Yii::$app->params['kunciInggris'] )),'asal'=>'site/index']),['class' => 'btn dark btn-sm btn-outline sbold uppercase modalWindow']);

                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-6">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption caption-md">
                    <i class="icon-bar-chart font-green"></i>
                    <span class="caption-subject font-green bold uppercase">Pasien Selesai</span>
                    <span class="caption-helper">5 Terakhir</span>
                </div>
                
            </div>
            <div class="portlet-body">
                <div class="table-scrollable table-scrollable-borderless">
                    <table class="table table-hover table-light">
                        <thead>
                            <th>MR</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </thead>
                        <tbody>
                            <?php foreach($selesai as $val): ?>
                                <tr>
                                    <td><?= Html::encode($val['mr']) ?></td>
                                    <td><?= Html::encode($val['mr0']['nama']) ?></td>
                                    <td><?= Html::encode($val['mr0']['alamat']) ?></td>
                                    <td>
                                        <?= (isset($val['bayar'][0]['no_invoice']))? Html::button('Invoice', ['value'=>Url::to(['bayar/view','id'=>$val['bayar'][0]['no_invoice'],'asal'=>'site/index']),'class' => 'btn dark btn-sm btn-outline sbold uppercase modalWindow']):"" ?>
                                        <?php 

                                        $id = utf8_encode(Yii::$app->security->encryptByKey( $val['rekamMedis'][0]['rm_id'], Yii::$app->params['kunciInggris'] ));

                                        echo Html::a('RM', Url::to(['rekam-medis/view','id'=>$id]), [
                                                'title' => Yii::t('yii', 'Lihat'),
                                                'class' => "btn dark btn-sm btn-outline sbold uppercase"
                                            ]); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-sm-6">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption caption-md">
                    <i class="icon-bar-chart font-green"></i>
                    <span class="caption-subject font-green bold uppercase">Presentase Hasil Diagnosis Dokter</span>
                </div>
                
            </div>
            <div class="portlet-body">

                <?php
                    echo Highcharts::widget([
                       'options' => [
                          'chart' => ['type'=>'pie'],
                          'title' => ['text' => ''],
                          'tooltip' => ['pointFormat'=>'{series.name}: <b>{point.percentage:.1f}%</b>'],
                          'plotOptions'=> [
                                    'pie' => [
                                        'allowPointSelect' => true,
                                        'cursor'=> 'pointer',
                                        'dataLabels' => [
                                            'enabled'=> false
                                        ],
                                        'showInLegend'=> true
                                    ]
                                ],
                          
                          'series' => [
                             [
                             'name' => 'Diagnosis', 
                             'colorByPoint' => true,
                             'data' => $diagnosisDR
                             ],
                          ]
                       ]
                    ]);
                    ?>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-6">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption caption-md">
                    <i class="icon-bar-chart font-green"></i>
                    <span class="caption-subject font-green bold uppercase">Presentase Hasil Diagnosis Klinik</span>
                </div>
                
            </div>
            <div class="portlet-body">
                <?php
                    echo Highcharts::widget([
                       'options' => [
                          'chart' => ['type'=>'pie'],
                          'title' => ['text' => ''],
                          'tooltip' => ['pointFormat'=>'{series.name}: <b>{point.percentage:.1f}%</b>'],
                          'plotOptions'=> [
                                    'pie' => [
                                        'allowPointSelect' => true,
                                        'cursor'=> 'pointer',
                                        'dataLabels' => [
                                            'enabled'=> false
                                        ],
                                        'showInLegend'=> true
                                    ]
                                ],
                          
                          'series' => [
                             [
                             'name' => 'Diagnosis', 
                             'colorByPoint' => true,
                             'data' => $diagnosisKlinik
                             ],
                          ]
                       ]
                    ]);
                    ?>
            </div>
        </div>
    </div>    

    <div class="col-md-12 col-sm-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption caption-md">
                    <i class="icon-bar-chart font-green"></i>
                    <span class="caption-subject font-green bold uppercase">Pasien 12 Bulan Terakhir</span>
                </div>
                
            </div>
            <div class="portlet-body">

                <?php
                    echo Highcharts::widget([
                        'options' => [
                            'chart' => ['type'=>'column'],
                              'title' => ['text' => 'Pasien 12 Bulan Terakhir'],
                              'xAxis' => [
                                 'categories' => $jlhPasien12Bln['bulan']
                              ],
                              'yAxis' => [
                                 'title' => ['text' => 'Jumlah Pasien Tertangani']
                              ],
                              'series' => [
                                 ['name' => 'Jumlah Pasien', 'data' => $jlhPasien12Bln['jlh']]
                              ]
                           ]
                    ]);
                    ?>
            </div>
        </div>
    </div>
    
    
    <div class="col-md-12 col-sm-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption caption-md">
                    <i class="icon-bar-chart font-red"></i>
                    <span class="caption-subject font-red bold uppercase">Stok Obat Kurang dari 30 sediaan (mis. 30 tablet)</span>
                </div>
                
            </div>
            <div class="portlet-body">

                <?php
                    echo Highcharts::widget([
                        'options' => [
                            'chart' => ['type'=>'column'],
                              'title' => ['text' => 'Daftar Stok Obat Kurang dari 30 sediaan'],
                              'xAxis' => [
                                 'categories' => $jlhStock['merk']
                              ],
                              'yAxis' => [
                                 'title' => ['text' => 'Stok kurang dari 30 sediaan']
                              ],
                              'series' => [
                                 ['name' => 'Jumlah Stok', 'color'=> 'red', 'data' => $jlhStock['jlh']]
                              ]
                           ]
                    ]);
                    ?>
            </div>
        </div>
    </div>
    
    
    
</div>

<div class="row">
    <div class="col-md-6">
        <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
            <h4 class="widget-thumb-heading">Pasien 3 Bulan Terakhir</h4>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-green icon-users"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Pasien</span>
                    <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?= $pasien_bulan ?>"><?= $pasien_bulan ?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
            <h4 class="widget-thumb-heading">Pasien Hari Ini</h4>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-red icon-user"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Pasien</span>
                    <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?= $pasien ?>"><?= $pasien ?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
            <h4 class="widget-thumb-heading">Pendapatan Hari Ini</h4>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-purple icon-magic-wand"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Rp</span>
                    <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?= $total_hari['total'] ?>"><?= number_format($total_hari['total'] ?? 0 ,0,'','.')?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="widget-thumb widget-bg-color-white text-uppercase margin-bottom-20 bordered">
            <h4 class="widget-thumb-heading">Pendapatan Bulan Ini</h4>
            <div class="widget-thumb-wrap">
                <i class="widget-thumb-icon bg-blue icon-briefcase"></i>
                <div class="widget-thumb-body">
                    <span class="widget-thumb-subtitle">Rp</span>
                    <span class="widget-thumb-body-stat" data-counter="counterup" data-value="<?= $total_bulan['total'] ?>"><?= number_format($total_bulan['total'] ?? 0 ,0,'','.') ?? 0 ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="notifCanvas">
    
</div>


<?php
$notif = Url::to(['pasien-next-visit/list']);
$script = <<< JS
    $(function(){
        $('.modalWindow').click(function(){
            $('#kartik-modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'))
        })

         var time = new Date().getTime();
         $(document.body).bind("mousemove keypress", function(e) {
             time = new Date().getTime();
         });

         

         function refresh() {
             if(new Date().getTime() - time >= 60000) 
                 window.location.reload(true);
             else 
                 setTimeout(refresh, 10000);
         }

         setTimeout(refresh, 10000);
    });
    
JS;
$script.= "$('.notifCanvas').load('".$notif."', function(){
    $('.modalWindow-reminder').click(function(){
            $('#modal-reminder').modal('show')
                .find('#modalContent-reminder')
                .load($(this).attr('value'))
        })
});";
$this->registerJs($script);
?>
