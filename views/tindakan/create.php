<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Tindakan */

$this->title = 'Buat Tindakan';
$this->params['breadcrumbs'][] = ['label' => 'Tindakans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tindakan-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
