<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TindakanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tindakan';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="tindakan-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::button('Tindakan Baru', ['value'=>Url::to(['tindakan/create']),'class' => 'btn btn-success modalWindow']) ?>
    </p>

    <?php
        Modal::begin([
                'header' => '<h4>Tindakan</h4>',
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

            //'tindakan_id',
            //'klinik_id',
            'nama_tindakan',
            'tarif_dokter:decimal',
            'tarif_asisten:decimal',
            // 'created',
            // 'modified',

            ['class' => 'yii\grid\ActionColumn',
             'template' => '{update} {view} {delete}',
             'buttons' => [
                'update' => function($url,$model) {
                     return Html::button('<i class="fa fa-edit"></i>', [
                            'value'=>$url,
                            'class'=>'btn dark btn-sm btn-outline sbold uppercase modalWindow',
                            'title' => Yii::t('yii', 'Update'),
                        ]);
                },
                'delete' => function($url,$model) {
                     return (!$model->biaya_wajib) ? Html::a('<i class="fa fa-trash-o"></i>', $url, [
                            'title' => Yii::t('yii', 'Hapus'),
                            'class'=> 'btn dark btn-sm btn-outline sbold uppercase',
                            'data-confirm' => Yii::t('yii', 'Apakah Anda Yakin akan menghapus Tindakan ini?'),
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
