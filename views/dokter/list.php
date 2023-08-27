<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DokterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dokter';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dokter-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Buat Pengguna', ['dokter/create-dokter'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'user_id',
            'nama',
            'no_telp',
            'no_telp_2',
            'spesialis',
            // 'waktu_praktek',
            // 'foto:ntext',
            'alamat:ntext',
            // 'tanggal_lahir',
            // 'created',

            [
              'class' => 'yii\grid\ActionColumn',
              'template' => '{delete}',
              'buttons' => [
                'delete' => function ($url, $model) {

                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['dokter/delete-dokter'], [
                        'data'=>[
                            'method' => 'post',
                            'confirm' => 'Anda yakin ingin menghapus dokter ini?',
                            'params'=>['id'=>$model->user_id],
                        ]
                    ]);
                }
              ],
            ],
        ],
    ]); ?>
</div>
