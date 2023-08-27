<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<body class=" page-404-full-page">
        <div class="row">
            <div class="col-md-12 page-404">
                <div class="number font-red"> <?php echo $exception->statusCode!=""?  $exception->statusCode: "500"?><br> </div>
                <div class="details">
                    <h3><?= nl2br(Html::encode($message)) ?></h3>
                    <p> Terjadi Kesalahan saat memproses permintaan anda.
                        <br/>
                        Harap <a href="https://api.whatsapp.com/send?phone=6282133762905" target = "_blank">Hubungi kami </a>  apabila anda merasa ini adalah kesalahan sistem<br>
                        atau kembali ke <?= Html::a('beranda', ['/']) ?>.
                        
                </div>
            </div>
        </div>
