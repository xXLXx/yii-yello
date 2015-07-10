<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class ShiftListAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

    ];
    public $js = [
        'js/moment.min.js',
        'js/shiftList.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\jui\JuiAsset',
    ];
}