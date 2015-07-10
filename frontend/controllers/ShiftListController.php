<?php

namespace frontend\controllers;

use \yii\web\Response;
use \yii\helpers\Url;
use \common\models\Shift;
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

            $listHtml = $this->renderPartialShifts($shifts);
            $quantityHtml = (string)count($shifts) . ' Shifts';

            $response = \Yii::$app->response;
            $response->format = Response::FORMAT_JSON;
            $response->data = [
                'listHtml' => $listHtml,
                'quantityHtml' => $quantityHtml,
            ];

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

        if ( $request->isAjax ) {

            $response = \Yii::$app->response;
            $response->format = Response::FORMAT_JSON;
            $response->data = [];

            $shiftId = (int)$request->get('shiftId');
            $isApproved = (bool)$request->get('approved');
            $shift = Shift::findOne(['id' => $shiftId]);
            if ( $shift ) {

                if ( $isApproved ) {

                    $shift->setStateCompleted(1, 0);
                    $shift = Shift::findOne(['id' => $shiftId]);

                    $response->data['itemHtml'] = $this->renderPartialShifts([$shift]);
                    $response->data['shiftId'] = $shift->id;
                }

                $driver = $shift->driverAccepted;
                $viewHtml = $this->renderPartial('shiftDetails', [
                    'shift' => $shift,
                    'driver' => $driver,
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

}
