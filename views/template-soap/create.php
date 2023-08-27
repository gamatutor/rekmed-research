<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TemplateSoap */

$this->title = 'Tambah Template SOAP';
$this->params['breadcrumbs'][] = ['label' => 'Template Soaps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="template-soap-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
