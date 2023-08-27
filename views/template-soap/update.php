<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TemplateSoap */

$this->title = 'Update Template Soap: ' . $model->nama_template;
$this->params['breadcrumbs'][] = ['label' => 'Template Soaps', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="template-soap-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
