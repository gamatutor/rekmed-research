<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SpesialisSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Spesialis';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="spesialis-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::button('Tambah', ['value'=>Url::to(['spesialis/create']),'class' => 'btn btn-success modalWindow']) ?>
    </p>
     <?php
        Modal::begin([
                'header' => '<h4>Spesialis</h4>',
                'id' => 'modal',
            ]);

        echo "<div id='modalContent'></div>";

        Modal::end();

    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'spesialis_id',
            'nama',

            ['class' => 'yii\grid\ActionColumn',
             'template' => '{update} {delete}',
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
                            'data-confirm' => Yii::t('yii', 'Apakah Anda Yakin akan menghapus Tindakan ini?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ]);
                },
                
             ]
            ],
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
