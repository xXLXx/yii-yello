<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class ShiftRequestReviewAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        
    ];
    public $js = [
        'js/controllers/ShiftRequestReviewController.js'
    ];
    public $depends = [
    ];
}
