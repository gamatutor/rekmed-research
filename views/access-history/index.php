<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel app\models\AccessHistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Access Histories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="access-history-index">

    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>
<?php
        Modal::begin([
                'id' => 'modal',
            ]);

        echo "<div id='modalContent'></div>";

        Modal::end();

    ?>
    
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'user:ntext',
            'ip_address:ntext',
            //'host:ntext',
            'agent:ntext',
            //'url:ntext',
            'time_akses',

            ['class' => 'yii\grid\ActionColumn',
             'template' => '{view}',
             'buttons' => [
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
