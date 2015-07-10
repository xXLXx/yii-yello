<?php
/**
 * @var $shift \common\models\Shift
 * @var $shiftRequestReviews \common\models\ShiftRequestReview[]
 * @var $reviewForm \frontend\models\ShiftRequestReviewForm
 */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Role;
?>

<div class="popup width-540">
    <div class="popup-title">
        <h3>Dispute Log</h3>
    </div>
    <div class="popup-body">
        <div class="popup-body-inner request-review">

            <div class="border-top-list profile-view">

                <?php foreach( $shiftRequestReviews as $requestReview ): ?>

                    <?php if( $requestReview->user->role->name !== Role::ROLE_DRIVER ): ?>
                        <div class="border-top-item">
                            <h5>You've requested Review of deliveries from <?= $shift->deliveryCount; ?> to <?= $requestReview->deliveryCount; ?></h5>
                            <div class="middle-gray-text">
                                <?= (new \DateTime($requestReview->createdAtAsDatetime))->format('j F Y, g:i A'); ?>
                            </div>
                            <div>
                                <?= $requestReview->text; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="border-top-item">
                            <h5>Driver has submitted <?= $requestReview->deliveryCount; ?> Deliveries for Approval</h5>
                            <div class="middle-gray-text">
                                <?= (new \DateTime($requestReview->createdAtAsDatetime))->format('j F Y, g:i A'); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>

                <div class="border-top-item">
                    <div>Request review again</div>
                </div>
            </div>

            <?php $form = ActiveForm::begin([
                'layout' => 'horizontal',
                'id' => 'shift-request-review-form',
                'options' => [
                    'enctype' => 'multipart/form-data'
                ],
            ]); ?>

            <?= Html::activeHiddenInput($reviewForm, 'shiftId', [
                'value' => $shift->id,
            ]); ?>

            <div class="form-inline-group">
                <label for="review-title" class="bold-text">Reviewed No. of Deliveries</label>
                <?= Html::activeTextInput($reviewForm, 'title', [
                    'class' => 'text-input small',
                    'placeholder' => Yii::t('app', 'Placeholder'),
                    'id' => 'review-title'
                ]); ?>
                <?= Html::error($reviewForm, 'title', ['class' => 'error-message']); ?>
            </div>

            <?= Html::activeTextarea($reviewForm, 'text', [
                'placeholder' => Yii::t ('app', 'Type here reason of review'),
                'class' => 'textarea',
            ]); ?>
            <?= Html::error($reviewForm, 'text', ['class' => 'error-message']); ?>

            <div class="button-container text-right">
                <?= Html::submitButton(\Yii::t('app', 'Request'), [
                    'class' => 'btn blue',
                ]); ?>

            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>