<?php
/**
 * @var $this yii\web\View
 * @var $shift \common\models\Shift
 * @var $shiftState \common\models\ShiftState
 * @var $lastDeliveryCount String
 * @var $review common\models\ShiftReviews
 *
 */

?>
<div class="border-top-item">
    <div class="table-block">
        <div class="table-cell-item">
            <h3>Shift #<?= $shift->id; ?>, <?= (new \DateTime($shift->start))->format('j F, Y'); ?></h3>
            <div class="sticker <?= $shiftState->color; ?>"><?= $shiftState->title; ?></div>
        </div>
    </div>
    <div class="table-block">
        <div class="table-cell-item">
            <h4>Booked time</h4>
            <h3>
                <span class="inline-block">
                    Start <?= (new \DateTime($shift->start))->format('g:ia'); ?>
                </span>&nbsp
                <span class="inline-block">
                    End <?= (new \DateTime($shift->end))->format('g:ia'); ?>
                </span>
            </h3>
        </div>
        <div class="table-cell-item">
            <?php if( $shift->actualStart || $shift->actualEnd ): ?>

                <h4>Actual time</h4>

                <?php if( $shift->actualStart ): ?>
                    <div class="inline-block"><h3>Start <span class="green-text"><?= (new \DateTime($shift->actualStart))->format('g:ia'); ?></span></h3></div>
                <?php endif; ?>

                <?php if( $shift->actualEnd ): ?>
                    <div class="inline-block"><h3>End <span class="red-text"><?= (new \DateTime($shift->actualEnd))->format('g:ia'); ?></span></h3></div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <div class="table-cell-item">
            <?php if( $shift->actualStart && $shift->actualEnd ): ?>
                <h4>Time spent</h4>
                <h3>
                    <?php
                    $dateEnd = new \DateTime($shift->actualEnd);
                    $dateStart = new \DateTime($shift->actualStart);
                    echo $dateEnd->diff($dateStart)->format('%h hours %i min');
                    ?>
                </h3>
            <?php endif; ?>
        </div>
    </div>
    <div class="table-block">
        <div class="table-cell-item">

            <h4>Driver fee</h4>
            <h3>$5 For Delivery</h3>
            <div>(Minimum 12 deliveries)</div>

        </div>

        <div class="table-cell-item">
            <?php if ( $shift->deliveryCount ): ?>
                <h4>Completed deliveries</h4>
                <h3 id="shiftdeliverycount"><?= $lastDeliveryCount; ?></h3>
            <?php endif; ?>
        </div>
        <div class="table-cell-item"></div>
    </div>
</div>

<!--
<div class="border-top-item small-margin j_request_review">
    <h4>Requested rewiew</h4>
    <p>
        Status: <span class="orange-text text-icon icon-alarm-clock">pending /</span> <span class="green-text text-icon icon-chat-1-1">Accepted</span>
        <br/>
        No. of deliveries for review: <span class="bold-text">12</span>
    </p>
    <p>
        Reason:<br/>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit.<br/>Pellentesque eu volutpat nibh.
    </p>
</div>
-->
<div id="shift-request-review">
    <div></div>
<?php if($shift->shiftRequestReview): ?>
<div class="border-top-item">
    <h4>Dispute Log</h4>
    <?php /*foreach($shift->shiftRequestReview as $item){
        //print_r($item);continue;
        $user_data = \common\models\User::find($item->userId);
        ?>
        <div class="table-block">
            <div class="table-cell-item">
                <?= $item->createdAt; ?>
            </div>
            <div class="table-cell-item">
                <?= $item->userId; ?> has disputed payment.<br/>
                No. of deliveries for review: <?= $item->deliveryCount; ?><br/>
                Reason:<br/>
                <?= $item->text; ?>
            </div>
            <div class="table-cell-item"></div>
            <div class="table-cell-item"></div>
        </div>
    <?php }*/ ?>
    <?php foreach( $shift->shiftRequestReview as $requestReview ): ?>

        <div class="table-block">
            <div class="gray-text pull-left">
                <?= (new \DateTime($requestReview->createdAtAsDatetime))->format('j M, Y, g:i A'); ?>&nbsp;&nbsp;
            </div>
            <div class="pull-left">
                <?php
                if( $requestReview->user->role->name !== \common\models\Role::ROLE_DRIVER ): ?>
                    You've requested Review of deliveries from <?= $shift->deliveryCount; ?> to <?= $requestReview->deliveryCount; ?>
                <?php else: ?>
                    Driver has submitted <?= $requestReview->deliveryCount; ?> Deliveries for Approval
                <?php endif; ?>
                <br>Reason:<br>
                <?= $requestReview->text; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>
</div>
<div class="border-top-item">
    <!--
    <h4 class="bold-text black-text">Total to pay</h4>
    <h2 class="bold-text">$145</h2>
    -->

    <div class="table-block">
        <div class="table-cell-item">
            <?php if ( 1 || $shift->payment ): ?>
                <h3>Total to Pay</h3>
                <h2 id="totalpayment">$<?= $shift->payment; ?></h2>
            <?php endif; ?>
        </div>
        <div class="table-cell-item"></div>
        <div class="table-cell-item">

        </div>
    </div>
    <div class="recall-block">
        <?php if( $shiftState->name === $shiftState::STATE_APPROVAL || $shiftState->name === $shiftState::STATE_DISPUTED || $shiftState->name === $shiftState::STATE_UNDER_REVIEW): ?>
            <h4 class="inline-block valign-middle">Rate Driver</h4>

            <?php echo \kartik\rating\StarRating::widget(['value' => 0, 'disabled' => false]); ?>
            <div><textarea class="textarea j_driver-review" placeholder="Write a review for driver!"></textarea></div>

            <div class="button-container j_request_link">

                <a href="<?= \yii\helpers\Url::to(['shift-request-review/index']) ?>?shiftId=<?= $shift->id; ?>" class="btn j_colorbox">Request Review</a>
                <a href="#" id="link-approve-shift" class="btn blue" rel="nofollow" data-shift-id="<?= $shift->id; ?>">Approve</a>
            <?php endif; ?>
        </div>
    </div>

        <?php if( $shiftState->name === $shiftState::STATE_COMPLETED && !empty($review) && $review instanceof \common\models\ShiftReviews): ?>
        <div class="border-top-item">
            <div class="recall-block">

                <h4 class="inline-block valign-middle">JOB REVIEW</h4><?php echo \kartik\rating\StarRating::widget(['value' => $review->stars, 'disabled' => true]); ?>
        <p><?= \yii\helpers\Html::encode($review->text)?></p>

        <div class="button-container j_request_link">
        </div>
                </div>

            <?php endif; ?>
        </div>

</div>
