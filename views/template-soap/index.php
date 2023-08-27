<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TemplateSoapSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Template SOAP';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="template-soap-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Tambah Template SOAP', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nama_template',
            [
                'attribute'=>'subject',
                'format'=>'raw'
            ],
            [
                'attribute'=>'object',
                'format'=>'raw'
            ],
            [
                'attribute'=>'assesment',
                'format'=>'raw'
            ],
            [
                'attribute'=>'plan',
                'format'=>'raw'
            ],
            // 'user',
            // 'created',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
