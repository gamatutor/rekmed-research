<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Pasien */

$this->title = $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Pasiens', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pasien-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= (!empty($model->foto)) ? Html::img('@web/'.$model->foto,['style'=>'height:150px','class'=>'img-responsive']) : "" ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'mr',
            'klinik_id',
            'nama',
            'no_nik',
            'tanggal_lahir',
            'jk',
            'alamat:ntext',
            'no_telp',
            'email',
            'pekerjaan',
            'penanggung_jawab',
            [
                'attribute'=>'alergi',
                'format'=>'html'
            ],
            // 'created',
            // 'modified',
            // 'user_input',
            // 'user_modified',
        ],
    ]) ?>

</div>
