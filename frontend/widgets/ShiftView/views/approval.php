<?php
/**
 * @var $shift \common\models\Shift
 */
use yii\helpers\Url;
use frontend\widgets\ShiftViewActiveDriver\ShiftViewActiveDriverWidget;

$shiftRequestReviews = $shift->shiftRequestReview;
?>

<h4><?= Yii::t('app', 'Driver'); ?></h4>
<?php if ($shift->driverAccepted): ?>
    <?=
    ShiftViewActiveDriverWidget::widget([
        'driverId' => $shift->driverAccepted->id
    ]);
    ?>
<?php endif; ?>
<div class="border-top-block">

    <div class="bold-text">No. Of completed deliviries: <span class="red-text"><?= $shift->deliveryCount ?></span></div>
    <div class="bold-text">Total payment: $<?= $shift->payment ?></div>

    <?php if(!$shiftRequestReviews): ?>

        <div class="j_request_link">
            <br/>
            <a class="btn small j_colorbox"
               href="<?= Url::to(['shift-request-review/index', 'shiftId' => $shift->id]); ?>">
                <?= Yii::t('app', 'Request Review'); ?>
            </a>
        </div>

    <?php endif; ?>

</div>

<?php if($shiftRequestReviews): ?>

    <div class="border-top-block small-margin j_request_review">
        <div class="border-top-block-inner">
            <div class="text-icon big-padding-2 red-text icon-red-2 font-exclamation-circle">
                You've requested review of deliveries <?= $shift->deliveryCount; ?> to
                    <span id="last-delivery-count"><?= $shift->lastUserShiftRequestReview->deliveryCount; ?></span>.
            </div>
            <div class="text-icon big-padding-2">
                <a href="<?= Url::to(['shift-request-review/dispute-log', 'shiftId' => $shift->id]); ?>" class="blue-text j_colorbox">
                    View Dispute Log (
                        <span id="dispute-log-quantity">
                            <?= count($shiftRequestReviews); ?>
                        </span>)
                </a>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="border-top-block">
    <a  class="btn blue js-shift-approve" href="<?= Url::to(['shift-store-owner/shift-approve',
        'shiftId' => $shift->id
    ]); ?>"><?= Yii::t('app', 'Approve'); ?></a>
</div>
