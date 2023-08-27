<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Tindakan */

$this->title = $model->tindakan_id;
$this->params['breadcrumbs'][] = ['label' => 'Tindakans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tindakan-view">



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nama_tindakan',
            'tarif_dokter',
            'tarif_asisten',
            'created',
            //'modified',
        ],
    ]) ?>

</div>
