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
class MetronicAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all',
        'metronic/global/plugins/font-awesome/css/font-awesome.min.css',
        'metronic/global/plugins/simple-line-icons/simple-line-icons.min.css',
        'metronic/global/plugins/bootstrap/css/bootstrap.min.css',
        'metronic/global/plugins/uniform/css/uniform.default.css',
        'metronic/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css',
        'metronic/global/css/components.min.css',
        'metronic/global/css/plugins.min.css',
        'metronic/layouts/layout4/css/layout.min.css',
        'metronic/layouts/layout4/css/themes/light.min.css',
        'metronic/layouts/layout4/css/custom.min.css',
        'css/site.css',
    ];
    public $js = [
        'metronic/global/plugins/bootstrap/js/bootstrap.min.js',
        'metronic/global/plugins/js.cookie.min.js',
        'metronic/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js',
        'metronic/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js',
        'metronic/global/plugins/jquery.blockui.min.js',
        'metronic/global/plugins/uniform/jquery.uniform.min.js',
        'metronic/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js',
        'metronic/global/scripts/app.min.js',
        'metronic/layouts/layout4/scripts/layout.min.js',
        'metronic/layouts/layout4/scripts/demo.min.js',
        'metronic/layouts/global/scripts/quick-sidebar.min.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
