<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RekamMedisSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pasien yang HPL di Bulan '. date("F Y");

$this->params['breadcrumbs'][] = $this->title;
?>


<div class="rekam-medis-hpl">

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
