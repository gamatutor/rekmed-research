<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Kunjungan */

$this->title = 'Pendaftaran';
$this->params['breadcrumbs'][] = ['label' => 'Kunjungans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kunjungan-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
