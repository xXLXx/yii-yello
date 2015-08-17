<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/font-style.css',
        'css/styles.css',
        'css/colorbox.css',
        'css/main.css',
        'css/vanilla.css',
        'css/star-rating.css'
//        'css/datepicker.css'
    ];
    public $js = [
        'js/cusel-2.5.js',
        'js/jquery-migrate-1.2.1.js',
        'js/function.js',
//        'js/vow.min.js',
//        'js/nm.js',
//        'js/nmConfig.js',
        'js/star-rating.js',
        'js/underscore-min.js',
        'js/moment.min.js',
        'js/jquery.jscrollpane.min.js',
        'js/helpers/WaitHelper.js',
        'js/jquery.colorbox-min.js',
        'js/ImageUploadPreview.js',
        'js/vanilla.js'
//        'js/bootstrap-datepicker.js'
    ];
    public $depends = [
        'yii\web\YiiAsset'
    ];
}
