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
class DataTableAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css',
        '//cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css',
    ];
    public $js = [
        '//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js',
        '//cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js',
        '//cdn.datatables.net/buttons/1.3.1/js/buttons.flash.min.js',
        '//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js',
        '//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js',
        '//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js',
        '//cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js',
        '//cdn.datatables.net/buttons/1.3.1/js/buttons.print.min.js',
    ];
    public $depends = [
            '\yii\web\JqueryAsset'
        ];
}
