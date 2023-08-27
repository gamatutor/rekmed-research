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
class NotificAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'metronic/global/plugins/jquery-notific8/jquery.notific8.min.css',
    ];

    public $js = [
        'metronic/global/plugins/jquery-notific8/jquery.notific8.min.js',
    ];
    public $depends = [
            '\yii\web\JqueryAsset'
        ];
}