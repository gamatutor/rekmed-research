<?php

use yii\helpers\Html;
use yii\helpers\Url ;
use yii\grid\GridView;
use dosamigos\datepicker\DatePicker;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel app\models\KunjunganSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Farmasi';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kunjungan-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php
        Modal::begin([
                'header' => '<h4>Farmasi</h4>',
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
             'template' => '{resep} {view}',

             'buttons' => [
                'resep' => function($url,$model) {
                    $id = utf8_encode(Yii::$app->security->encryptByKey( $model->rekamMedis[0]['rm_id'], Yii::$app->params['kunciInggris'] ));

                    return Html::a('<span class="btn btn-default fa fa-file-text-o"></span>', Url::to(['rekam-medis/cetak-resep','id'=>$id]), [
                            'title' => Yii::t('yii', 'Resep'),
                            'data-pjax' => '0',
                            'target' => '_blank'
                        ]); 
                },
                'view' => function($url,$model) {
                    return Html::button('Resep', [
                            'value'=>Url::to(['rekam-medis/check-obat','kunjungan_id'=>utf8_encode(Yii::$app->security->encryptByKey( $model->kunjungan_id, Yii::$app->params['kunciInggris'] )),'asal'=>'kunjungan/farmasi']),
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

