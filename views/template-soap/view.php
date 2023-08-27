<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TemplateSoap */

$this->title = $model->nama_template;
$this->params['breadcrumbs'][] = ['label' => 'Template Soaps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="template-soap-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nama_template',
            [
                'attribute'=>'subject',
                'format'=>'raw'
            ],
            [
                'attribute'=>'object',
                'format'=>'raw'
            ],
            [
                'attribute'=>'assesment',
                'format'=>'raw'
            ],
            [
                'attribute'=>'plan',
                'format'=>'raw'
            ],
            'user0.username',
            'created',
        ],
    ]) ?>

</div>
