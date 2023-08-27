<?php



/* @var $this \yii\web\View */

/* @var $content string */



use yii\helpers\Html;

use yii\helpers\Url;

use yii\bootstrap\Nav;

use yii\bootstrap\NavBar;

use yii\widgets\Breadcrumbs;

use app\assets\MetronicAsset;

?>

<?php $this->beginPage() ?>

<!DOCTYPE html>

<html lang="<?= Yii::$app->language ?>">

<head>
<!-- Chatra {literal} -->
<script>
    (function(d, w, c) {
        w.ChatraID = 'P9y3WGmmwGuTwPvRX';
        var s = d.createElement('script');
        w[c] = w[c] || function() {
            (w[c].q = w[c].q || []).push(arguments);
        };
        s.async = true;
        s.src = (d.location.protocol === 'https:' ? 'https:': 'http:')
        + '//call.chatra.io/chatra.js';
        if (d.head) d.head.appendChild(s);
    })(document, window, 'Chatra');
</script>
<!-- /Chatra {/literal} -->
<!-- Piwik -->
<script type="text/javascript">
  var _paq = _paq || [];
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="//rekmed.com/piwik/";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', '1']);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<noscript><p><img src="//rekmed.com/piwik/piwik.php?idsite=1" style="border:0;" alt="" /></p></noscript>
<!-- End Piwik Code -->
    <meta charset="<?= Yii::$app->charset ?>">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="<?= Yii::getAlias('@web/favicon.ico') ?>"/>

    <?= Html::csrfMetaTags() ?>

    <title><?= Html::encode($this->title) ?></title>

    <?php $this->head() ?>

</head>

<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo">

<?php $this->beginBody() ?>



<div class="page-container">

    

    <!-- BEGIN CONTENT -->

        <!-- BEGIN CONTENT BODY -->

        <div class="page-content">

            

            <div class="row">

                <div class="col-md-12">

                    <div class="portlet light bordered">

                        <div class="portlet-title">

                            <div class="caption font-red-sunglo">

                                <i class="icon-settings font-red-sunglo"></i>

                                <span class="caption-subject bold uppercase"><?= $this->title ?></span>

                            </div>

                        </div>

                        <div class="portlet-body form">

                            <?= $content ?>

                        </div>

                    </div>

                </div>

            

            </div>



        </div>

</div>



<?php 

$this->registerJsFile('@web/metronic/global/scripts/app.min.js',['depends'=>'app\assets\MetronicAsset']); 

$this->registerJsFile('@web/metronic/layouts/layout4/scripts/layout.min.js',['depends'=>'app\assets\MetronicAsset']); 

$this->registerJsFile('@web/metronic/layouts/layout4/scripts/demo.min.js',['depends'=>'app\assets\MetronicAsset']); 

$this->registerJsFile('@web/metronic/layouts/global/scripts/quick-sidebar.min.js',['depends'=>'app\assets\MetronicAsset']); 



$this->endBody() 



?>

</body>

</html>

<?php $this->endPage() ?>

