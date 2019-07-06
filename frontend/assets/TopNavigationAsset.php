<?php

namespace frontend\assets;

use yii\web\AssetBundle;
class TopNavigationAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $js = [
        'js/moment.min.js',
        'js/moment-timezone.min.js',
        'js/top-navigation.js'
    ];
}
