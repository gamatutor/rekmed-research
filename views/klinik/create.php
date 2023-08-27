<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Klinik */

$this->title = 'Buat Klinik / RS';
$this->params['breadcrumbs'][] = ['label' => 'Klinik / RS', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="klinik-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
