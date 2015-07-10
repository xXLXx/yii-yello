<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class StoreInviteDriverAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        
    ];
    public $js = [
        'js/controllers/StoreInviteDriverController.js'
    ];
    public $depends = [
    ];
}
