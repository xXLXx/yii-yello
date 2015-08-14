<?php
/**
 * @var $shift \common\models\Shift
 */
use yii\helpers\Url;
use frontend\widgets\ShiftViewActiveDriver\ShiftViewActiveDriverWidget;
// original submission
// Shift recociliation
$deliverycount = $shift->deliveryCount;
$lastrequest = null;
$deliveryamount = $shift->payment;
$shiftRequestReviews = $shift->shiftRequestReview;
$lastdriverrequest = $shift->LastDriverShiftRequestReview;
$driverreview=null;
$userreview = null;
$latest='';
$userId = Yii::$app->user->identity->id;
$msg='';

if($shiftRequestReviews){
// get the most recent 2 arguments
    foreach ($shiftRequestReviews as $review){
            if($review->userId==$userId){
                    $userreview=$review;
                    $latest='user';
                }else{
                $driverreview=$review;
                $deliverycount=$review->deliveryCount;
                $latest='driver';
            }
    }
    if($lastdriverrequest){
        $deliverycount = $lastdriverrequest->deliveryCount;
    }
    
    // figure out the most recent argument
    if($latest=='user'){
        $msg = "You've requested review of $deliverycount to <span id='last-delivery-count'>$userreview->deliveryCount</span>.";
    }else{
        $msg = "Driver has responded to your review of $userreview->deliveryCount with <span id='last-delivery-count'>$deliverycount</span>.";
    }
    
    
}

  $deliveryamount = $deliverycount*5;
  if($deliveryamount<60){
      $deliveryamount=60;
  }
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
    <div class="bold-text">No. Of completed deliveries: <span class="red-text"><?= $deliverycount  ?></span></div>
    <div class="bold-text">Total payment: $<?= $deliveryamount ?></div>

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
                <?=$msg?>
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
