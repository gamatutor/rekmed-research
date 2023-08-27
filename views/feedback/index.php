<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FeedbackSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Feedback';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
    Modal::begin([
            'header' => '<h4>Feedback</h4>',
            'id' => 'modal',
        ]);

    echo "<div id='modalContent'></div>";

    Modal::end();

?>

<div class="feedback-index">
    <p>
        <?= Html::button('Buat Feedback', ['value'=>Url::to(['feedback/create']),'class' => 'btn btn-success modalWindow']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function($model){
                if($model->is_new==1) return ['class'=>'danger'];
                else return ['class'=>''];
            },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'kategori',
            'isi:html',
            'created',
            [
                'attribute' => 'user_id',
                'value' => 'user.username'
            ],

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
                     return Html::a('<i class="fa fa-trash-o"></i>', $url, [
                            'title' => Yii::t('yii', 'Hapus'),
                            'class'=> 'btn dark btn-sm btn-outline sbold uppercase',
                            'data-confirm' => Yii::t('yii', 'Apakah Anda Yakin akan menghapus Tindakan ini?'),
                            'data-method' => 'post',
                            'data-pjax' => '0',
                        ]);
                },
                'view' => function($url,$model) {
                    return Html::button('<i class="fa fa-mail-reply"></i>', [
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

