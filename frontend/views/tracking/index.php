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
    <table class="tracking-status">
    	<tr>
    		<th>Drivers OTR</th>
    		<th></th>
    		<th></th>
    		<th></th>
    	</tr>
    	<tr>
    		<td class="drivers-count">0</td>
    		<td></td>
    		<td></td>
    		<td></td>
    	</tr>
    </table>
</div>

<?php
    $this->registerJs("TrackingMapController.init({selector: '#map-canvas', store: " . json_encode($store) .", drivers:" . json_encode($drivers) . "});");
?>