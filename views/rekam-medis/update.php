<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RekamMedis */

$this->title = 'Update Rekam Medis';
$this->params['breadcrumbs'][] = ['label' => 'Rekam Medis', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="rekam-medis-update">

    <?= $this->render('_form', compact('model','rm_diagnosis_id','rm_diagnosis_text','rm_diagnosis_banding_id','rm_diagnosis_banding_text','rm_tindakan','rm_obat','rm_obatracik','rm_obatracik_komponen','kunjungan','data_exist','histori_rm')) ?>

</div>
