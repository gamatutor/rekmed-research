<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AccessHistory */

$this->title = $model->user;
$this->params['breadcrumbs'][] = ['label' => 'Access Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="access-history-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user:ntext',
            'ip_address:ntext',
            'host:ntext',
            'agent:ntext',
            'url:ntext',
            'time_akses',
        ],
    ]) ?>

</div>
