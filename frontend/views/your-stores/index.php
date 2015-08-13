<?php

use yii\helpers\Html;
use frontend\widgets\SettingsLeftNavigation;

$this->title = \Yii::t('app', 'Your Stores');

?>

<div class="sidebar-container">
    <?= SettingsLeftNavigation::widget(); ?>
    <div class="col-right">
        <!-- Your Stores -->

        <h2 class="with-button">Your Stores<?= Html::a(\Yii::t('app', 'Add Store'), ['store-add/index'], ['class' => 'btn blue small']) ?>
        </h2>
        <div class="store-list">
            <?php foreach ($stores as $store): ?>
            <div class="store-list-item">
                <div class="company-logo-container f-left">
                    <a href="<?= \yii\helpers\Url::to(['store-edit/index', 'storeId' => $store->id]) ?>">
                        <img src="<?= $store->image ? $store->image->thumbUrl : '/img/store_image.svg' ?>">
                    </a>
                </div>
                <div class="company-info">
                    <div class="company-info-inner">
                    <h3>
                        <?= Html::a($store->title,['store-edit/index', 'storeId' => $store->id]) ?>
                    </h3>
                    <div class="company-adress gray-text">
                        <?= $store->address ? $store->address->address1 : ''; ?><br>
                        <?= $store->address ? $store->address->address2 : ''; ?>
                    </div>
<!--                    <div>-->
<!--                        <span class="star-block">-->
<!--                            <span class="font-star-two"></span>-->
<!--                            <span class="font-star-two"></span>-->
<!--                            <span class="font-star-two"></span>-->
<!--                            <span class="font-star-two"></span>-->
<!--                            <span class="font-star-half"></span>-->
<!--                        </span>-->
<!--                        <span class="state green" style="float: right"> <span class="icon-link-2"></span>Franchisor Name...</span>-->
<!--                        <span class="state red" style="float: right"> <span class="icon-bubble-attention-7"></span>Invintation</span>-->
<!--                    </div>-->
                    </div>
                </div>
            </div>
            <?php endforeach;?>
        </div>
    </div>