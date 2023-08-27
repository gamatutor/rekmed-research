<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Dokter */

$this->title = 'Create Dokter';
$this->params['breadcrumbs'][] = ['label' => 'Dokters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dokter-create">


    <?= $this->render('_formUntukDokter', [
        'model' => $model,
        'user' => $user,
    ]) ?>

</div>
