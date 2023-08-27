<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Spesialis */

$this->title = 'Update Spesialis: ' . $model->spesialis_id;
$this->params['breadcrumbs'][] = ['label' => 'Spesialis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->spesialis_id, 'url' => ['view', 'id' => $model->spesialis_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="spesialis-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
