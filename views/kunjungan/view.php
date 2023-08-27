<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Kunjungan */

$this->title = 'Nomor RM : '.$model->mr;
$this->params['breadcrumbs'][] = ['label' => 'Kunjungans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kunjungan-view">

    <p>
        <?= Html::a('Delete', ['delete', 'id' => $model->kunjungan_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'mr',
            'tanggal_periksa',
            'jam_masuk',
            'jam_selesai',
            'status',
            'created',
            'user_input',
        ],
    ]) ?>

</div>
