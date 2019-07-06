<?php
/**
 * @var $shift \common\models\Shift
 * @var $reviewForm \frontend\models\ShiftRequestReviewForm
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<div class="popup width-340">
    <div class="popup-title">
        <h3><?= \Yii::t('app', 'Review for shift #{id}', ['id' => $shift->id]); ?></h3>
    </div>
    <div class="popup-body">
        <div class="popup-body-inner request-review">

            <?php $form = ActiveForm::begin([
                'layout' => 'horizontal',
                'id' => 'shift-request-review-form',
                'fieldConfig' => [
                    'template' => '{input}{error}',
                    'horizontalCssClasses' => [
                        'error' => 'error-message'
                    ]
                ],
                'options' => [
                    'enctype' => 'multipart/form-data'
                ]
            ]); ?>

            <?= Html::activeHiddenInput($reviewForm, 'id'); ?>
            <?= Html::activeHiddenInput($reviewForm, 'shiftId'); ?>
            <p><?= \Yii::t('app', 'Driver entered {deliveryCount} Deliveries', [
                    'deliveryCount' => $shift->deliveryCount
                ]); ?></p>
            <?= Html::errorSummary($reviewForm, ['class' => 'red-error-text']) ?>
            <label for="review" class="bold-text"><?= \Yii::t('app', 'No. Of deliveries for review'); ?></label>
            <?= Html::activeTextInput($reviewForm, 'title', [
                'class'         => 'text-input small',
                'placeholder'   => \Yii::t('app', 'No. of deliveries'),
                'id'            => 'review'
            ]) ?>
            <?= Html::activeTextarea($reviewForm, 'text', [
                'placeholder'   => \Yii::t ('app', 'Type here reason of review'),
                'class'         => 'textarea'
            ]) ?>

            <div class="button-container">
                <a href="javascript:;" class="btn j_colorbox_close"><?= \Yii::t('app', 'Cancel'); ?></a>
                <?= Html::submitButton(\Yii::t('app', 'Request'), [
                    'class'   => 'btn blue'
                ]) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>