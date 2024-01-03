<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RekamMedisSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rekam Medis Terakhir';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="rekam-medis-index">

<?php Pjax::begin(); ?>    
<div class="table-responsive">
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'rm_id',
            //'user_id',
            //'kunjungan_id',
            'mr',
            [
                'attribute' => 'pasien_nama',
                'value' => 'mr0.nama'
            ],
            
            //'tekanan_darah',
            //'nadi',
            //'respirasi_rate',
            // 'suhu',
            // 'berat_badan',
            // 'tinggi_badan',
            // 'bmi',
            //'keluhan_utama:ntext',
            //'anamnesis:ntext',
            // 'pemeriksaan_fisik:ntext',
            // 'hasil_penunjang:ntext',
            // 'deskripsi_tindakan:ntext',
            // 'saran_pemeriksaan:ntext',
            [
                'attribute' => 'created',
                'format' => ['date', 'php:d-F-Y'],
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'created',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ])
            ],
            // 'modified',

            ['class' => 'yii\grid\ActionColumn',
            'template' => '{update} {view} {delete} {upload} {unduh} {resep} ',
            'buttons' => [
                'update' => function($url,$model) {
                     $id = utf8_encode(Yii::$app->security->encryptByKey( $model->rm_id, Yii::$app->params['kunciInggris'] ));
                     return (!$model->locked) ? Html::a('<span class="btn btn-default fa fa-pencil"></span>', Url::to(['rekam-medis/update','id'=>$id]), [
                            'title' => Yii::t('yii', 'Proses'),
                            'data-pjax' => '0',
                        ]) : "";
                },
                'view' => function($url,$model) {
                    $id = utf8_encode(Yii::$app->security->encryptByKey( $model->rm_id, Yii::$app->params['kunciInggris'] ));

                    return Html::a('<span class="btn btn-default fa fa-eye"></span>', Url::to(['rekam-medis/view','id'=>$id]), [
                            'title' => Yii::t('yii', 'Lihat'),
                            'data-pjax' => '0',
                        ]); 
                },

                'delete' => function($url,$model) {
                     $id = utf8_encode(Yii::$app->security->encryptByKey( $model->rm_id, Yii::$app->params['kunciInggris'] ));
                     return (!$model->locked) ? Html::a('<i class="fa fa-trash-o"></i>', Url::to(['rekam-medis/delete','id'=>$id]), [
                            'title' => Yii::t('yii', 'Hapus'),
                            'class'=> 'btn btn-default',
                            'data-confirm' => Yii::t('yii', 'Apakah Anda Yakin akan menghapus Rekam Medis ini?'),
                            'data-method' => 'post',
                        ]) : "";
                },

                'upload' => function($url,$model) {
                    $id = utf8_encode(Yii::$app->security->encryptByKey( $model->rm_id, Yii::$app->params['kunciInggris'] ));

                    return Html::a('<span class="btn btn-default fa fa-cloud-upload"></span>', Url::to(['rekam-medis/upload','id'=>$id]), [
                            'title' => Yii::t('yii', 'Upload Penunjang'),
                            'data-pjax' => '0',
                        ]); 
                },

                'unduh' => function($url,$model) {
                    $id = utf8_encode(Yii::$app->security->encryptByKey( $model->rm_id, Yii::$app->params['kunciInggris'] ));

                    return Html::a('<span class="btn btn-default fa fa-file-pdf-o"></span>', Url::to(['rekam-medis/unduh-rm','id'=>$id]), [
                            'title' => Yii::t('yii', 'Unduh RM'),
                            'data-pjax' => '0',
                            'target' => '_blank'
                        ]); 
                },

                'resep' => function($url,$model) {
                    $id = utf8_encode(Yii::$app->security->encryptByKey( $model->rm_id, Yii::$app->params['kunciInggris'] ));

                    return Html::a('<span class="btn btn-default fa fa-file-text-o"></span>', Url::to(['rekam-medis/cetak-resep','id'=>$id]), [
                            'title' => Yii::t('yii', 'Resep'),
                            'data-pjax' => '0',
                            'target' => '_blank'
                        ]); 
                }
             ]
            ],
        ],
    ]); ?>
</div>
<?php Pjax::end(); ?></div>
<!--<?= Html::a("Backup Rekam Medis",['rekam-medis/unduh-all-rm'], ['target' => '_blank', 'class'=>'btn btn-success'] ) ?>-->

<form action="<?= Url::to(['rekam-medis/unduh-all-rm']) ?>" class="form-inline" id="form-backup">
  <div class="form-group">
    <label for="">Dari</label>
    <input type="date" name="date_start" id="date_start" value="<?= date('Y-m-d', strtotime('-2 months')) ?>" class="form-control" style="width:150px;" />
  </div>
  <div class="form-group">
    <label for="">Sampai</label>
    <input type="date" name="date_end" id="date_end" value="<?= date('Y-m-d') ?>" class="form-control" style="width:150px;" />
  </div>
  <button type="submit" class="btn btn-success">Backup Rekam Medis</button>
</form>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
  $(document).ready(function () {
    $("#form-backup").submit(function (event) {
      // Prevent form submission
      event.preventDefault();

      // Get the selected dates
      var startDate = new Date($("#date_start").val());
      var endDate = new Date($("#date_end").val());
      
      // Calculate the difference in days
      var timeDiff = endDate.getTime() - startDate.getTime();
      var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));

      // Get tomorrow's date
      var tomorrow = new Date();
      tomorrow.setDate(tomorrow.getDate() + 1);

      // Validate the date range
      if (diffDays > 62) {
        alert("Rentang tanggal tidak boleh melebihi 2 bulan");
      } else if (endDate.getTime() === tomorrow.getTime()) {
        alert("Tidak dapat memilih tanggal melewati hari ini");
      } else {
        // If validation passes, submit the form
        this.submit();
      }
    });
  });
</script>
