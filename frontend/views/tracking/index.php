<?php

use frontend\assets\TrackingAsset;
use yii\helpers\Html;

TrackingAsset::register($this);

$this->title = \Yii::t('app', 'Tracking');
?>

<div class="full-content">
    <div class="top-menu">
        <button class="btn-image" onclick="TrackingMapController.panToStoreLocation()"><?= Html::img('@web/img/stroke.svg') ?></button>
    </div>
    <div id="map-canvas"></div>
</div>

<?php
    $this->registerJs("TrackingMapController.init({selector: '#map-canvas', store: " . json_encode($store) .", drivers:" . json_encode($drivers) . "});");
?>