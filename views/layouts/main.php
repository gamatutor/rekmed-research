<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\MetronicAsset;
use app\models\Menu;
use app\models\Dokter;

$dokter = Dokter::findOne(Yii::$app->user->identity->id);

$menu_temp    = Menu::find()->joinWith('menuAkses')->where(['role' => Yii::$app->user->identity->role])->orderBy('menu_order')->asArray()->all();
$realUsername = Yii::$app->user->identity->realUsername;
$menu         = [];
$menu_child   = [];
foreach ($menu_temp as $key => $value) {
    if ($value['menu_root'] > 0) {
        $menu_child[$value['menu_root']]['nama'][]  = $value['menu_nama'];
        $menu_child[$value['menu_root']]['icon'][]  = $value['menu_icon'];
        $menu_child[$value['menu_root']]['route'][] = $value['menu_route'];
    } else {
        $menu[$value['menu_id']]['nama']  = $value['menu_nama'];
        $menu[$value['menu_id']]['icon']  = $value['menu_icon'];
        $menu[$value['menu_id']]['route'] = $value['menu_route'];
    }
}

MetronicAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?= Yii::getAlias('@web/favicon.ico') ?>" />
    <?= Html::csrfMetaTags() ?>
    <title>
        <?= Html::encode($this->title) ?>
    </title>
    <?php $this->head() ?>
</head>

<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo">
    <?php $this->beginBody() ?>

    <!-- BEGIN HEADER -->
    <div class="page-header navbar navbar-fixed-top">
        <!-- BEGIN HEADER INNER -->
        <div class="page-header-inner ">

            <!-- BEGIN LOGO -->
            <a href="https://api.whatsapp.com/send?phone=6281228944870" target="_blank">Hubungi kami </a>
            <!-- <input type="text" class="form-control" name="KunjunganSearch[mr]" style="width:80%"> -->
            <div class="page-logo">
                <a href="http://www.rekmed.com" target="_blank">
                    <?= Html::img('@web/metronic/layouts/layout4/img/logo-light.png', ['alt' => 'logo', 'class' => 'logo-default', 'style' => 'height:50px;margin-top:10px']) ?>
                </a>
                <div class="menu-toggler sidebar-toggler">
                    <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
                </div>
            </div>
            <!-- END LOGO -->
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse"
                data-target=".navbar-collapse"> </a>
            <!-- END RESPONSIVE MENU TOGGLER -->

            <!-- BEGIN PAGE TOP -->
            <div class="page-top">
                <!-- BEGIN TOP NAVIGATION MENU -->
                <div class="top-menu">
                    <ul class="nav navbar-nav pull-right">
                        <!-- BEGIN USER LOGIN DROPDOWN -->
                        <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                        <li class="dropdown dropdown-user dropdown-light">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                                data-close-others="true">
                                <span class="username username-hide-on-mobile">
                                    <?= Yii::$app->user->identity->username ?>
                                    <?php echo $realUsername != '' ? "(simulasi)" : "" ?>
                                </span>
                                <!-- DOC: Do not remove below empty space(&nbsp;) as its purposely used -->
                                <?= empty($dokter->foto) ? Html::img('@web/img/DR-avatar.png', ['class' => 'img-circle']) : Html::img('@web/' . $dokter->foto, ['class' => 'img-circle']) ?>
                            </a>
                        </li>
                        <!-- END USER LOGIN DROPDOWN -->
                    </ul>
                    <ul class="nav navbar-nav pull-left">
                        <li class="">
                            <form method="get" action="<?= Yii::$app->urlManager->createUrl(['site/search']) ?>">
                                <input type="hidden" name="r" value="site/search">
                                <input type="text" class="form-control" name="q" placeholder="Cari"
                                    style="margin-top:20px;width:800px;">
                            </form>
                        </li>
                        <!-- END USER LOGIN DROPDOWN -->
                    </ul>
                </div>
                <!-- END TOP NAVIGATION MENU -->
            </div>
            <!-- END PAGE TOP -->
        </div>
        <!-- END HEADER INNER -->
    </div>
    <!-- END HEADER -->
    <!-- BEGIN HEADER & CONTENT DIVIDER -->
    <div class="clearfix"> </div>
    <!-- END HEADER & CONTENT DIVIDER -->
    <!-- BEGIN CONTAINER -->
    <div class="page-container">
        <!-- BEGIN SIDEBAR -->
        <div class="page-sidebar-wrapper">
            <!-- BEGIN SIDEBAR -->
            <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
            <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
            <div class="page-sidebar navbar-collapse collapse">
                <!-- BEGIN SIDEBAR MENU -->
                <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
                <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
                <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
                <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
                <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->


                <ul class="page-sidebar-menu" data-keep-expanded="true" data-auto-scroll="true" data-slide-speed="200">
                    <?php foreach ($menu as $menu_id => $menu_value): ?>
                        <li class="nav-item">
                            <?= isset($menu_child[$menu_id]) ? '<a href="javascript:;" class="nav-link nav-toggle xpnded"><i class="fa fa-' . $menu_value['icon'] . '"></i><span class="title">' . $menu_value['nama'] . '</span><span class="arrow open"></span></a>' : Html::a('<i class="fa fa-' . $menu_value['icon'] . '"></i><span class="title">' . $menu_value['nama'] . '</span>', Url::to([$menu_value['route']])) ?>

                            <?php
                            if (isset($menu_child[$menu_id])) {
                                echo '<ul class="sub-menu">';
                                foreach ($menu_child[$menu_id]['nama'] as $key => $nama_menu) {
                                    echo "<li class='nav-item'>" . Html::a('<i class="fa fa-' . $menu_child[$menu_id]['icon'][$key] . '"></i><span class="title">' . $nama_menu . '</span>', Url::to([$menu_child[$menu_id]['route'][$key]])) . "</li>";
                                }
                                echo '</ul>';
                            }
                            ?>
                        </li>
                    <?php endforeach; ?>
                    <li>
                        <?=
                            Html::a('<i class="fa fa-commenting"></i><span class="title"> Feedback', Url::to(['feedback/index'])) ?>
                    </li>

                    <li class="heading">
                        <style type="text/css">
                            .pastiPas {
                                width: 100% !important;
                                overflow: hidden !important;
                            }
                        </style>
                        <?=
                            Html::beginForm(['/site/logout'], 'post')
                            . Html::submitButton(
                                '<i class="icon-key"></i> Logout (' . Yii::$app->user->identity->username . ')',
                                ['class' => 'btn btn-default pastiPas']
                            )
                            . Html::endForm()
                            ?>
                    </li>
                    <li class="nav-item">
                        <br />
                    </li>
                </ul>

            </div>
            <!-- END SIDEBAR -->
        </div>
        <!-- END SIDEBAR -->
        <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <!-- BEGIN CONTENT BODY -->
            <div class="page-content">
                <?= Breadcrumbs::widget([
                    'itemTemplate' => '<li>{link}</li>&nbsp;<i class="fa fa-circle"></i> &nbsp;',
                    'options'      => ['class' => 'page-breadcrumb breadcrumb'],
                    'links'        => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>

                <?php if (Yii::$app->session->getFlash('error')): ?>
                    <div class="custom-alerts alert alert-danger fade in"><button type="button" class="close"
                            data-dismiss="alert" aria-hidden="true"></button><span
                            class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        <?= Yii::$app->session->getFlash('error'); ?>
                    </div>
                <?php endif; ?>
                <?php if (Yii::$app->session->getFlash('success')): ?>
                    <div class="custom-alerts alert alert-success fade in"><button type="button" class="close"
                            data-dismiss="alert" aria-hidden="true"></button><span class="glyphicon glyphicon-ok-sign"
                            aria-hidden="true">
                            <?= Yii::$app->session->getFlash('success'); ?>
                    </div>
                <?php endif; ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet light bordered">
                            <div class="portlet-title">
                                <div class="caption font-red-sunglo">
                                    <i class="icon-settings font-red-sunglo"></i>
                                    <span class="caption-subject bold uppercase">
                                        <?= $this->title ?>
                                    </span>
                                </div>
                            </div>
                            <div class="portlet-body form">

                                <?= $content ?>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <?php
            $this->registerJsFile('@web/metronic/global/scripts/app.min.js', ['depends' => 'app\assets\MetronicAsset']);
            $this->registerJsFile('@web/metronic/layouts/layout4/scripts/layout.min.js', ['depends' => 'app\assets\MetronicAsset']);
            $this->registerJsFile('@web/metronic/layouts/layout4/scripts/demo.min.js', ['depends' => 'app\assets\MetronicAsset']);
            $this->registerJsFile('@web/metronic/layouts/global/scripts/quick-sidebar.min.js', ['depends' => 'app\assets\MetronicAsset']);
            //to expand all expandable navitems
// $this->registerJs("$('.xpnded').trigger('click');");
            $this->endBody()

                ?>
</body>

</html>
<?php $this->endPage() ?>