<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PasienSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pasien';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    .table-responsive .btn{
        width:40px;
        margin-bottom: 3px;
    }
</style>

<div class="pasien-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php
        Modal::begin([
                'header' => '<h4>Pasien</h4>',
                'id' => 'modal',
            ]);

        echo "<div id='modalContent'></div>";

        Modal::end();

    ?>
    <p>
        <?= Html::button('Pasien Baru', ['value'=>Url::to(['pasien/create']),'class' => 'btn btn-success modalWindow']) ?>
    </p>
  
<div class="table-responsive">
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'mr',
            //'klinik_id',
            'no_nik',
            'nama',
            'tanggal_lahir',
            'jk',
            'alamat:ntext',
            'no_telp',
            // 'pekerjaan',
            // 'penanggung_jawab',
            // 'created',
            // 'modified',
            // 'user_input',
            // 'user_modified',

            ['class' => 'yii\grid\ActionColumn',
             'template' => '<p style="width:150px"> {update} {view} {delete}  {kartu} {reminder} {resumeMedis}</p>',
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
                            'data-confirm' => Yii::t('yii', 'Apakah Anda Yakin akan menghapus Pasien ini?'),
                            'data-method' => 'post',
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
                },
                'reminder' => function($url,$model) {
                    return Html::button('<i class="fa fa-calendar-plus-o"></i>', [
                            'value'=>Url::to(['pasien-next-visit/create','id'=>$model->mr]),
                            'class'=>'btn dark btn-sm btn-outline sbold uppercase modalWindow',
                            'title' => Yii::t('yii', 'Tambah Reminder'),
                            'data-pjax' => '0',
                        ]);  
                },
                'kartu' => function($url,$model) {
                    return Html::a('<i class="fa fa-credit-card"></i>', $url, ['class'=>'btn dark btn-sm btn-outline sbold uppercase','title' => Yii::t('yii', 'Kartu Pasien'),]);  
                },
                'resumeMedis' => function($url,$model) {
                    return Html::a('<i class="fa fa-file-pdf-o"></i>', Url::to(['pasien/resume-medis','id'=>utf8_encode(Yii::$app->security->encryptByKey( $model->mr, Yii::$app->params['kunciInggris'] ))]),['class' => 'btn dark btn-sm btn-outline sbold uppercase','title' => Yii::t('yii', 'Resume Medis')]);
                },
                
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
