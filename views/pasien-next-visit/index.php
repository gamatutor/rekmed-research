<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PasienNextVisitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Jadwal Kunjungan Pasien';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pasien-next-visit-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'mr',
            'agenda',
            'next_visit',
            // 'created_at',

            ['class' => 'yii\grid\ActionColumn',
             'buttons' => [
                'view' => function($url,$model) {
                    return Html::a('<i class="fa fa-eye"></i>','javascript:;', [
                            'value'=>$url,
                            'class'=>'modalWindow-reminder',
                            'title' => Yii::t('yii', 'Lihat'),
                            'data-pjax' => '0',
                        ]);  
                },
             ]
            ],
        ],
    ]); ?>
</div>
<?php
        Modal::begin([
                'header' => '<h4>Reminder</h4>',
                'id' => 'modal-reminder',
            ]);

        echo "<div id='modalContent-reminder'></div>";

        Modal::end();

    ?>

<?php
$script = <<< JS
    $(function(){
        $('.modalWindow-reminder').click(function(){
            $('#modal-reminder').modal('show')
                .find('#modalContent-reminder')
                .load($(this).attr('value'))
        })
    });
JS;

$this->registerJs($script);
?>