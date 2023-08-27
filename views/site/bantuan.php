<?php

use yii\helpers\Html;

$this->title = 'Bantuan';
$this->params['breadcrumbs'][] = $this->title;
?>

<div id="myCarousel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
    <li data-target="#myCarousel" data-slide-to="3"></li>
    <li data-target="#myCarousel" data-slide-to="4"></li>
  </ol>
  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="item active">
      <?= Html::img('@web/help/1.jpg') ?>
    </div>

    <div class="item">
      <?= Html::img('@web/help/2.jpg') ?>
      
    </div>

    <div class="item">
      <?= Html::img('@web/help/3.jpg') ?>
    </div>

    <div class="item">
      <?= Html::img('@web/help/4.jpg') ?>
    </div>

    <div class="item">
      <?= Html::img('@web/help/5.jpg') ?>
    </div>
  </div>

  <!-- Left and right controls -->
  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Sebelumnya</span>
  </a>
  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Selanjutnya</span>
  </a>
</div>