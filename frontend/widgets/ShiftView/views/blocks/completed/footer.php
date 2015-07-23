<div class="border-top-block">
    <div><?= \Yii::t('app', 'No. Of completed deliveries'); ?>: <span class="red-text"><?= $shift->deliveryCount ?></span></div>
    <div><?= \Yii::t('app', 'Approved Deliveries'); ?>: <span class="green-text"><?= $shift->deliveryCount ?></span></div>
    <div><?= \Yii::t('app', 'Total to pay'); ?>: $<?= $shift->payment ?></div>
    <div class="bold-text"><?= \Yii::t('app', 'Paid'); ?>: $<?= $shift->payment ?></div>
</div>