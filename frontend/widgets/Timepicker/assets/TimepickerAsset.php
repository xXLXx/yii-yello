<?php

namespace frontend\widgets\Timepicker\assets;

use yii\web\AssetBundle;

class TimepickerAsset extends AssetBundle
{
    public $sourcePath = '@frontend/widgets/Timepicker/resources';
    public $css = [
        'css/jquery-clockpicker.min.css',
    ];
    public $js = [
        'js/jquery-clockpicker.min.js',
        'js/TimepickerWidget.js'
    ];
    public $depends = [
        
    ];
}
