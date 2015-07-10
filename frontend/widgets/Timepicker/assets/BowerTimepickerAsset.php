<?php

namespace frontend\widgets\Timepicker\assets;

use yii\web\AssetBundle;

class BowerTimepickerAsset extends AssetBundle
{
    public $sourcePath = '@bower/bootstrap-timepicker';
    public $css = [
        'css/bootstrap-timepicker.min.css',
        'css/bootstrap-responsive.css'
    ];
    public $js = [
        'js/bootstrap-timepicker.min.js'
    ];
    public $depends = [
        
    ];
}
