<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class ShiftsCalendarAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        
    ];
    public $js = [
        'js/nice-calendar.js',
        'js/controllers/ShiftsCalendarController.js'
    ];
    public $depends = [
        'yii\jui\JuiAsset',
        'frontend\widgets\Timepicker\assets\TimepickerAsset',
        'frontend\widgets\DriverSearch\assets\DriverSearchAsset',
        'yii\widgets\ActiveFormAsset',
        'frontend\widgets\ShiftViewDriverAccepted\assets\ShiftViewDriverAcceptedAsset',
        'frontend\widgets\ShiftViewApplicants\assets\ShiftViewApplicantsAsset',
        'frontend\assets\ShiftRequestReviewAsset',
        'frontend\widgets\ShiftForm\assets\ShiftFormAsset',
        'frontend\widgets\ShiftView\assets\ShiftViewAsset'
    ];
}
