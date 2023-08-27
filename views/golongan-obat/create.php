<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\GolonganObat */

$this->title = 'Buat Golongan Obat';
$this->params['breadcrumbs'][] = ['label' => 'Golongan Obat', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="golongan-obat-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
