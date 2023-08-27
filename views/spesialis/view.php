<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Spesialis */

$this->title = $model->spesialis_id;
$this->params['breadcrumbs'][] = ['label' => 'Spesialis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="spesialis-view">

    

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'spesialis_id',
            'nama',
        ],
    ]) ?>

</div>
