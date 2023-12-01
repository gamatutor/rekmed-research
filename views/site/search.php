<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title                   = 'Hasil Pencarian';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <ul class="list-group">
        <?php foreach ($d as $i => $row): ?>
            <li class="list-group-item">
                Pasien:
                <?php if (isset($row['pasien'])): ?>
                    <a href="<?= Yii::$app->urlManager->createUrl(['rekam-medis/detail', 'id' => $row['pasien']['mr']]) ?>">
                        <?= $row['pasien']['nama'] ?>
                    </a>
                <?php else: ?>
                    <span>Pasien tidak ditemukan</span>
                <?php endif; ?><br>
                Rekam Medis:
                <?php if (isset($row['rekam_medis'])): ?>
                    <?php
                    $id = utf8_encode(Yii::$app->security->encryptByKey($row['rekam_medis']['rm_id'], Yii::$app->params['kunciInggris']));
                    ?>
                    <?= Html::a('Lihat', Url::to([
                        'rekam-medis/view',
                        'id' => $id,
                    ]), [
                        'title' => Yii::t('yii', 'Lihat'),
                        'class' => "btn dark btn-sm btn-outline sbold uppercase"
                    ]); ?>
                <?php else: ?>
                    <span>Rekam medis tidak ditemukan</span>
                <?php endif; ?><br>
                Deskripsi:
                <?= strlen($data[$i][2]) > 450 ? substr($data[$i][2], 0, 450) . '...' : $data[$i][2] ?>
            </li>
        <?php endforeach; ?>
    </ul>

</div>