<?php

namespace frontend\controllers;

use Yii;
use yii\helpers\Url;
use common\models\Shift;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use frontend\models\ShiftRequestReviewForm;
use yii\web\Response;

/**
 * Shift request review controller
 *
 * @author markov
 */
class ShiftRequestReviewController extends BaseController
{
    /**
     * Shift request review
     *
     * @param integer $shiftId shift id
     * @throws NotFoundHttpException
     */
    public function actionIndex($shiftId)
    {
        /* @var $shift Shift */
        $this->layout = 'empty';
        $shift = Shift::findOne($shiftId);
        if (!$shift) {
            throw new NotFoundHttpException('The shift not found.');
        }
        $post = Yii::$app->request->post();
        $reviewForm = new ShiftRequestReviewForm();
        $reviewForm->shiftId = $shiftId;
        if ( $reviewForm->load($post) && $reviewForm->validate() ) {
            $reviewForm->save();
//            return 'success';
            $response = Yii::$app->response;
            $response->format = Response::FORMAT_JSON;

            $viewHtml = $this->shiftRequestReviewDetailView($shift);

            return [
                'context' => 'viewHtml',
                'status' => 'success',
                'veiwHtml' => $viewHtml,
               ];
            
        } else {
            $shiftRequestReviewId = Yii::$app->request->post('id');
            $reviewForm->setData($shiftRequestReviewId);
        }
        
        return $this->render('index', [
            'shift'      => $shift,
            'reviewForm' => $reviewForm
        ]);
    }

    /**
     * ajax render dispute log
     *
     * @param $shiftId
     * @return string|\yii\web\Response
     * @throws BadRequestHttpException
     */
    public function actionDisputeLog($shiftId)
    {
        if (Yii::$app->request->isAjax) {

            /* @var $shift \common\models\Shift */
            $shift = Shift::findOne(['id' => $shiftId]);

            if ($shift) {

                $shiftRequestReviews = $shift->shiftRequestReviewDesc;
                $reviewForm = new ShiftRequestReviewForm();
                $post = Yii::$app->request->post();
                if ($reviewForm->load($post) && $reviewForm->validate() && $reviewForm->save()) {

                    $response = Yii::$app->response;
                    $response->format = Response::FORMAT_JSON;

                    return [
                        'context' => 'disputeLog',
                        'status' => 'success',
                        'requestReviewCount' => count($shift->shiftRequestReview),
                        'deliveryCount' => ($shift->lastUserShiftRequestReview ? $shift->lastUserShiftRequestReview->deliveryCount : 0),
                    ];
                }

                return $this->renderPartial('disputeLog', [
                    'shift' => $shift,
                    'shiftRequestReviews' => $shiftRequestReviews,
                    'reviewForm' => $reviewForm,
                ]);
            }

            throw new BadRequestHttpException;
        }
        else {
            return $this->redirect(Url::to(['shifts-calendar/index']), 301);
        }
    }

    private function shiftRequestReviewDetailView(Shift $shift, $driver = null , $isApproved = null)
    {
        if ($shift) {
            $deliverycount = $shift->deliveryCount;
            $lastrequest = null;
            $shiftRequestReviews = $shift->shiftRequestReview;
            $lastdriverrequest = $shift->LastDriverShiftRequestReview;
            $driverreview = null;
            $userreview = null;
            $latest = '';
            $userId = \Yii::$app->user->identity->id;
            $msg = '';
            if ($shiftRequestReviews) {
                // get the most recent 2 arguments
                foreach ($shiftRequestReviews as $review) {
                    if ($review->userId == $userId) { // ascertain the argument
                        $userreview = $review;
                        $latest = 'user';
                    } else {
                        $driverreview = $review;
                        $deliverycount = $review->deliveryCount;
                        $latest = 'driver';
                    }
                }
                if ($lastdriverrequest) {
                    $deliverycount = $lastdriverrequest->deliveryCount;
                }

                // figure out the most recent argument
                if ($latest == 'user') {
                    $msg = "You've requested review of $deliverycount to <span id='last-delivery-count'>$userreview->deliveryCount</span>.";
                } else {
                    $msg = "Driver has responded to your review of $userreview->deliveryCount with <span id='last-delivery-count'>$deliverycount</span>.";
                }
                $shift->deliveryCount = $deliverycount;

            }

            $deliveryamount = $deliverycount * 5;
            if ($deliveryamount < 60) {
                $deliveryamount = 60;
            }

            $viewHtml = $this->renderPartial('shiftRequestReview', [
                'shift' => $shift,
            ]);

            return $viewHtml;

        }else{

            return false;
        }

    }


}
