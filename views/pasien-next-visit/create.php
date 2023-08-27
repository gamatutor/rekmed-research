<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PasienNextVisit */

$this->title = 'Tambah Reminder Pasien';
$this->params['breadcrumbs'][] = ['label' => 'Pasien Next Visits', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pasien-next-visit-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
