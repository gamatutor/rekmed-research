<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Klinik */

$this->title = 'Update Klinik: ' . $model->klinik_id;
$this->params['breadcrumbs'][] = ['label' => 'Kliniks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->klinik_id, 'url' => ['view', 'id' => $model->klinik_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="klinik-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
