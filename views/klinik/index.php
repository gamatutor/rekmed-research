<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\KlinikSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Klinik';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
    Modal::begin([
            'header' => '<h4>Klinik</h4>',
            'id' => 'modal',
        ]);

    echo "<div id='modalContent'></div>";

    Modal::end();

?>

<div class="klinik-index">

    <p>
        <?= Html::button('Klinik Baru', ['value'=>Url::to(['klinik/create']),'class' => 'btn btn-success modalWindow']) ?>
    </p>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'klinik_id',
            'klinik_nama',
            'alamat:ntext',
            'nomor_telp_1',
            'nomor_telp_2',
            'kepala_klinik',

            ['class' => 'yii\grid\ActionColumn',
             'template' => '{update} {view} {credit}',
             'buttons' => [
                'update' => function($url,$model) {
                     return Html::button('<i class="fa fa-edit"></i>', [
                            'value'=>$url,
                            'class'=>'gridBtn btn dark btn-sm btn-outline sbold uppercase modalWindow',
                            'title' => Yii::t('yii', 'Update'),
                        ]);
                },
                'view' => function($url,$model) {
                    return Html::a('<i class="fa fa-eye"></i>',$url,['class'=>'gridBtn btn dark btn-sm btn-outline sbold uppercase']);
                    return Html::button('<i class="fa fa-eye"></i>', [
                            'value'=>$url,
                            'class'=>'gridBtn btn dark btn-sm btn-outline sbold uppercase modalWindow',
                            'title' => Yii::t('yii', 'Lihat'),
                            'data-pjax' => '0',
                        ]);  
                },
                'credit' => function($url,$model) {
                    return Html::button('<i class="fa fa-plus"></i>', [
                            'value'=>$url,
                            'class'=>'gridBtn btn dark btn-sm btn-outline sbold uppercase modalWindow',
                            'title' => Yii::t('yii', 'Tambah Credit RM'),
                            'data-pjax' => '0',
                        ]);  
                },
                
             ]],
        ],
    ]); ?>
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

