<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Pasien */

$this->title = 'Buat Pasien Baru';
$this->params['breadcrumbs'][] = ['label' => 'Pasiens', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pasien-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
