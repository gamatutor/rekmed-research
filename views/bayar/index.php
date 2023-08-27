<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BayarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Pembayaran';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bayar-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<?php
        Modal::begin([
                'id' => 'modal',
            ]);

        echo "<div id='modalContent'></div>";

        Modal::end();

    ?>
<?php Pjax::begin(); ?>    
<div class="table-responsive">
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'no_invoice',
            'mr',
            'nama_pasien',
            'alamat',
            [
                'attribute' => 'tanggal_bayar',
                'format' => ['date', 'php:d-F-Y'],
            ],
            // 'subtotal',
            // 'diskon',
            'total:decimal',
            // 'kembali',
            // 'bayar',
            // 'created',

            ['class' => 'yii\grid\ActionColumn',
             'template' => '{view} {delete}',
             'buttons' => [
                'delete' => function($url,$model) {
                     return Html::a('<i class="fa fa-trash-o"></i>', Url::to(['bayar/delete','id'=>$model->no_invoice,'asal'=>'bayar/index']), [
                            'title' => Yii::t('yii', 'Hapus'),
                            'class'=> 'btn dark btn-sm btn-outline sbold uppercase',
                            'data-confirm' => Yii::t('yii', 'Apakah Anda Yakin akan Membatalkan Pembayaran Ini?'),
                            'data-method' => 'post',
                        ]);
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
<?php Pjax::end(); ?></div>

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
