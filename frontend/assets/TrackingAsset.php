<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class TrackingAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

    ];
    public $js = [
        'https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true',
        'http://cdn.pubnub.com/pubnub-3.7.13.min.js',
        'js/controllers/TrackingMapController.js'
    ];
    public $depends = [

    ];
}
