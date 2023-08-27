<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Spesialis */

$this->title = 'Create Spesialis';
$this->params['breadcrumbs'][] = ['label' => 'Spesialis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="spesialis-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
