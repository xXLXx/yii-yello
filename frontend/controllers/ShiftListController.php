<?php

namespace frontend\controllers;
use common\helpers\ArrayHelper;
use common\helpers\TimezoneHelper;
use common\models\ShiftReviews;
use \yii\web\Response;
use \yii\helpers\Url;
use \common\models\Shift;
use yii\helpers\Json;
use common\models\Shiftsavailable;
/**
 * Shifts list for store owner
 *
 * @author Yarovikov
 */
class ShiftListController extends BaseController
{

    /**
     * render Shifts list for current user & current store
     *
     * @return string
     */
    public function actionIndex()
    {
        $storeCurrent = $this->getStoreCurrent();

        $currentDay = new \DateTime();

        $shiftsDataProvider = $storeCurrent->getAssignedShiftsByDate($currentDay);

        return $this->render('index', [
            'shiftsDataProvider' => $shiftsDataProvider,
            'currentDay' => $currentDay,
        ]);
    }

    /**
     * ajax action for shift-list/index date widget
     *
     * @return \yii\web\Response
     */
    public function actionList()
    {
        $request = \Yii::$app->request;

        if ( $request->isAjax ) {

            $date = $request->get('date');
            try {
                $date = new \DateTime($date);
            } catch (\Exception $e) {
                $date = null;
            }

            $storeCurrent = $this->getStoreCurrent();
            $shiftsDataProvider = $storeCurrent->getAssignedShiftsByDate( $date );
            $shifts = $shiftsDataProvider->getModels();

            if(!empty($shifts)){
                $firstShift = $shifts[0];
                $driver = $firstShift->driverAccepted;
                $viewHtml = $this->returnShiftViewDetail($firstShift, $driver);
            }


            $listHtml = $this->renderPartialShifts($shifts);
            $quantityHtml = (string)count($shifts) . ' Shifts';

            $response = \Yii::$app->response;
            $response->format = Response::FORMAT_JSON;
            $response->data = [
                'listHtml' => $listHtml,
                'quantityHtml' => $quantityHtml,
            ];

            if(!empty($viewHtml)){
                $response->data['viewHtml'] = $viewHtml;
                $response->data['shiftId'] = $firstShift->id;
            }
            if(empty($shifts))
            {
                $response->data['viewHtml'] = $this->renderPartial('_splash',['notToday' => true]);
            }

        } else {

            return $this->redirect(Url::to(['shift-list/index']), 301);
        }
    }

    
    


    
    
    
    /**
     * ajax action; html response with shift details
     *
     * @return string|\yii\web\Response
     */
    public function actionView()
    {
        $request = \Yii::$app->request;

        if ($request->isAjax) {

            $response = \Yii::$app->response;
            $response->format = Response::FORMAT_JSON;
            $response->data = [];

            $shiftId = (int)$request->get('shiftId');
            $isApproved = (bool)$request->get('approved');
            $reviewText = $request->get('reviewText');
            $reviewStars = $request->get('reviewStars');

            $shift = Shift::findOne(['id' => $shiftId]);
            $driver = $shift->driverAccepted;

            if($reviewText && $reviewStars){
                $review = ShiftReviews::findOneOrCreate(['shiftId' => $shiftId]);
                $review->stars = $reviewStars;
                $review->text = $reviewText;
                $review->storeId = $shift->storeId;
                $review->driverId = $driver->id;
                $review->save();
            }

            if ($shift) {
                $deliverycount = $shift->deliveryCount;
                $lastrequest = null;
                $deliveryamount = $shift->payment;
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
//                    $shift->deliveryCount = $deliverycount;

                }

                $deliveryamount = $deliverycount * 5;
                if ($deliveryamount < 60) {
                    $deliveryamount = 60;
                }


                if ($isApproved) {

                    $shift->setStateCompleted($deliverycount, $deliveryamount);
                    $shift = Shift::findOne(['id' => $shiftId]);
                }

                if($shift){
                    //As the $shift->setStateCompleted in the above update the shift in database, Changing timezone should be done
                    //after that.
                    $store = $shift->getStore()->one();
                    $timeZone = $store->getTimezone();
                    $shift->start = TimezoneHelper::convertGMTToTimeZone($timeZone, $shift->start);
                    $shift->end = TimezoneHelper::convertGMTToTimeZone($timeZone, $shift->end);

                    if($shift->actualStart){
                        $shift->actualStart = TimezoneHelper::convertGMTToTimeZone($timeZone,$shift->actualStart);
                    }
                    if($shift->actualEnd){
                        $shift->actualEnd = TimezoneHelper::convertGMTToTimeZone($timeZone,$shift->actualEnd);
                    }
                }

                if($isApproved){
                    //We should add the shift to the view after changing timezone.
                    $response->data['itemHtml'] = $this->renderPartialShifts([$shift]);
                    $response->data['shiftId'] = $shift->id;
                }

                if(!isset($review)){
                    $review = null;
                }

                $viewHtml = $this->renderPartial('shiftDetails', [
                    'shift' => $shift,
                    'driver' => $driver,
                    'lastDeliveryCount' => $deliverycount,
                    'review' => $review
                ]);

                $response->data['viewHtml'] = $viewHtml;
            }
        } else {

            return $this->redirect(Url::to(['shift-list/index']), 301);
        }
    }

    /**
     * get current store for user
     *
     * @return \common\models\Store
     */
    private function getStoreCurrent()
    {
        $user = \Yii::$app->user->identity;
        $storeOwner = $user->storeOwner;
        $storeCurrent = $storeOwner->storeCurrent;

        return $storeCurrent;
    }

    /**
     * @param \common\models\Shift[] $shifts
     * @return string
     */
    private function renderPartialShifts( array $shifts )
    {
        $output = '';

        if ( count($shifts) ) {

            foreach ($shifts as $model) {

                $output .= $this->renderPartial('_shiftItem', [
                    'model' => $model,
                ]);
            }
        } else {
            $output = \Yii::t('app', 'No shifts');
        }

        return $output;
    }

    /**
     * This function should return the shift with the id for both actionView and actionList. It is retrieved from actionView.
     * But now it is just serve the actionList and the code with actionView is duplicated. We should do fix it later but now
     * because the lack of time it just serving actionList.
     *
     *
     * @param \common\models\Shift $shift
     * @param  $driver
     * @param string $isApproved
     * @return string viewHtml
     */

    private function returnShiftViewDetail(Shift $shift, $driver = null , $isApproved = null)
    {
        if ($shift) {
            if(empty($driver)){
                $driver = $shift->driverAccepted;
            }
            $deliverycount = $shift->deliveryCount;
            $lastrequest = null;
            $deliveryamount = $shift->payment;
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


//            if ($isApproved) {
//
//                $shift->setStateCompleted($deliverycount, $deliveryamount);
//                $shift = Shift::findOne(['id' => $shiftId]);
//
//                $response->data['itemHtml'] = $this->renderPartialShifts([$shift]);
//                $response->data['shiftId'] = $shift->id;
//            }

            $viewHtml = $this->renderPartial('shiftDetails', [
                'shift' => $shift,
                'driver' => $driver,
            ]);

            return $viewHtml;

        }else{

            return false;
        }

    }

}
