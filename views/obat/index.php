<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ObatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Manajemen Obat';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="obat-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::button('Obat Baru', ['value'=>Url::to(['obat/create']),'class' => 'btn btn-success modalWindow']) ?>
    </p>

    <?php
        Modal::begin([
                'header' => '<h4>Obat</h4>',
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

            //'obat_id',
            //'klinik_id',
            'nama_merk',
            'pabrikan',
            'nama_generik',
            'golongan',
            // 'tanggal_beli',
            'tanggal_kadaluarsa',
            // 'harga_beli:decimal',
            'harga_jual:decimal',
            'stok',
            // 'created',
            // 'modified',

            ['class' => 'yii\grid\ActionColumn',
             'template' => '{update} {view} {stok} {delete}',
             'buttons' => [
                'update' => function($url,$model) {
                     return Html::button('<i class="fa fa-edit"></i>', [
                            'value'=>$url,
                            'class'=>'btn dark btn-sm btn-outline sbold uppercase modalWindow',
                            'title' => Yii::t('yii', 'Update'),
                        ]);
                },
                'delete' => function($url,$model) {
                     return Html::a('<i class="fa fa-trash-o"></i>', $url, [
                            'title' => Yii::t('yii', 'Hapus'),
                            'class'=> 'btn dark btn-sm btn-outline sbold uppercase',
                            'data-confirm' => Yii::t('yii', 'Apakah Anda Yakin akan menghapus Obat ini?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ]);
                },
                'stok' => function($url,$model) {
                    return Html::button('<i class="fa fa-medkit"></i>', [
                            'value'=>Url::to(['obat/stok','id'=>$model->obat_id]),
                            'class'=>'btn dark btn-sm btn-outline sbold uppercase modalWindow',
                            'title' => Yii::t('yii', 'Stok'),
                            'data-pjax' => '0',
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

