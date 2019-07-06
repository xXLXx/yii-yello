<?php

namespace frontend\widgets\Address\assets;

use yii\web\AssetBundle;

class AddressAsset extends AssetBundle
{
    public $sourcePath = '@frontend/widgets/Address/resources';
    public $css = [];
    public $js = [
        'https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=places',
        'js/AddressWidget.js'
    ];
    public $depends = [];
    public $publishOptions = [
        'forceCopy' => YII_DEBUG,
    ];
}
