<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class DriversAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        
    ];
    public $js = [
        'js/DriversFilter.js',
        'js/AddFavouriteDriver.js',
        'js/InviteDriver.js'
    ];
    public $depends = [
        'frontend\assets\StoreInviteDriverAsset'
    ];
}
