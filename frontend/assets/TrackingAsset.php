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
        '//maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&&libraries=geometry',
        '//cdn.pubnub.com/pubnub-3.7.13.min.js',
        '//google-maps-utility-library-v3.googlecode.com/svn/tags/markerclusterer/1.0.2/src/markerclusterer_compiled.js',
        'js/controllers/TrackingMapController.js'
    ];
    public $depends = [

    ];
}
