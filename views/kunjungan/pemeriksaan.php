<?php

use yii\helpers\Html;
use yii\helpers\Url ;
use yii\grid\GridView;
use dosamigos\datepicker\DatePicker;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel app\models\KunjunganSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pemeriksaan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kunjungan-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php
        Modal::begin([
                'header' => '<h4>Pemeriksaan</h4>',
                'id' => 'modal',
            ]);

        echo "<div id='modalContent'></div>";

        Modal::end();

    ?>
<div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'kunjungan_id',
            //'klinik_id',
            'mr',
            [
                'attribute' => 'pasien_nama',
                'value' => 'mr0.nama'
            ],
            [
                'attribute' => 'tanggal_periksa',
                'format' => ['date', 'php:d-F-Y'],
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'tanggal_periksa',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ])
            ],
            //'jam_masuk',
            //'jam_selesai',
            //'status',
            // 'created',
            // 'user_input',

            ['class' => 'yii\grid\ActionColumn',
             'template' => '{process} {view} {delete} {update}',

             'buttons' => [
                'process' => function($url,$model) {
                    return ($model->status=='antri') ? 
                     Html::a('<span class="fa fa-stethoscope"></span>', Url::to(['rekam-medis/create','kunjungan_id'=>utf8_encode(Yii::$app->security->encryptByKey( $model->kunjungan_id, Yii::$app->params['kunciInggris'] ))]), [
                            'class' => 'btn btn-default',
                            'title' => Yii::t('yii', 'Proses'),
                            'data-pjax' => '0',
                        ]) : ""; 
                },
                'update' => function($url,$model) {
                    return ($model->status=='antri obat' || $model->status=='antri periksa' || $model->status=='diperiksa') ? 
                     Html::a('<span class="fa fa-pencil"></span>', Url::to(['rekam-medis/update','id'=>utf8_encode(Yii::$app->security->encryptByKey( $model->rekamMedis[0]->rm_id, Yii::$app->params['kunciInggris'] ))]), [
                            'class' => 'btn btn-default',
                            'title' => Yii::t('yii', 'Proses'),
                            'data-pjax' => '0',
                        ]) : "";  
                },
                'delete' => function($url,$model) {
                    return ($model->status=='antri') ? Html::a('<span class="fa fa-trash-o"></span>', $url, [
                            'title' => Yii::t('yii', 'Hapus'),
                            'class' => 'btn btn-default',
                            'data-confirm' => Yii::t('yii', 'Apakah Anda Yakin akan menghapus antrian ini?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ]) : "";  
                },
                'view' => function($url,$model) {
                    return Html::button('<i class="fa fa-eye"></i>', [
                            'value'=>$url,
                            'class'=>'btn dark btn-sm btn-outline sbold uppercase modalWindow',
                            'title' => Yii::t('yii', 'Lihat'),
                            'data-pjax' => '0',
                        ]);  
                }
             ]
            ],
        ],
    ]); ?>
    </div>
</div>

<?php

$script = <<< JS
    $(function(){
        $('.modalWindow').click(function(){
            $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'))
        })
    });

JS;

$this->registerJs($script);
?>

