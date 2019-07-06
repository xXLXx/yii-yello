<?php
/**
 * @var $review common\models\ShiftReviews
 * @var $shift \common\models\Shift
 *
 *
 */
?>
<div></div>
<?php if($shift->shiftRequestReview): ?>
    <div class="border-top-item">
        <h4>Dispute Log</h4>
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