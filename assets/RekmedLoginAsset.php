<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */

// new_rekmed_asset
class RekmedLoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'assets/new_rekmed_asset/css/style.css',
        'assets/new_rekmed_asset/vendors/bootstrap/css/bootstrap.min.css',
        'assets/new_rekmed_asset/css/blue.css',
    ];
    public $js = [
        'assets/new_rekmed_asset/vendors/jquery/jquery.min.js',
        'assets/new_rekmed_asset/bootstrap/js/popper.min.js',
        'assets/new_rekmed_asset/bootstrap/js/bootstrap.min.js',
        'assets/new_rekmed_asset/js/jquery.slimscroll.js',
        'assets/new_rekmed_asset/js/waves.js',
        'assets/new_rekmed_asset/js/sidebarmenu.js',
        'assets/new_rekmed_asset/vendors/sticky-kit-master/dist/sticky-kit.min.js',
        'assets/new_rekmed_asset/vendors/sparklines/jquery.sparkline.min.js',
        'assets/new_rekmed_asset/js/custom.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        // 'yii\bootstrap\BootstrapAsset',
    ];
}
