<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class StoreSignupStepTwoAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        
    ];
    public $js = [
        'js/controllers/StoreSignupStepTwoController.js'
    ];
    public $depends = [
        'yii\web\YiiAsset'
    ];
}
