<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PasienNextVisit */

$this->title = $model->mr." : ".$model->agenda;
$this->params['breadcrumbs'][] = ['label' => 'Pasien Next Visits', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pasien-next-visit-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p style="margin-top: 20px">
        <?= Html::a('Tambah ke daftar kunjungan', ['add', 'id' => $model->pasien_schedule_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Batalkan jadwal', ['cancel', 'id' => $model->pasien_schedule_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to cancel this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'pasien.nama',
            'agenda',
            [
                'attribute'=>'desc',
                'format'=>'html'
            ],
            'next_visit',
        ],
    ]) ?>

</div>
