<?php
/**
 * Created by PhpStorm.
 * User: KustovVA
 * Date: 25.06.2015
 * Time: 18:20
 */

/** @var \common\models\Store $store */
/** @var \common\models\Image $image */
$image = $store->image;

?>
<div class="company-logo clearfix">
    <a href="#">
        <div class="company-logo-container f-left">
            <img src="/images/company/logo/<?= $store->company->id; ?>">
        </div>
    </a>
    <div class="company-info">
        <h5><a href="#"><?= $store->title ?></a></h5>

        <div class="star-block">
            <span class="font-star-two"></span>
            <span class="font-star-two"></span>
            <span class="font-star-two"></span>
            <span class="font-star-two"></span>
            <span class="font-star-half"></span>
        </div>
        <div class="gray-text">Joined <?= (new \DateTime($store->createdAtAsDatetime))->format('d M, Y') ?></div>
    </div>
</div>