<?php

namespace common\services;

use common\helpers\TimezoneHelper;
use common\models\Shift;
use yii\helpers\Url;
use common\models\ShiftState;

/**
 * Shift calendar service
 *
 * @author markov
 */
class ShiftCalendarService extends BaseService
{
    /**
     * Get events
     * 
     * @param array $data data
     * @return array
     */
    public static function getEvents($data)
    {
        $result = [];

        $start = $data['start'];
        $end = $data['end'];
        $timezone = $data['timezone'];
        
        $shifts = Shift::find()
            ->with('applicants')
            ->andWhere(['>=', 'start', $start->format('Y-m-d H:i:s')])
            ->andWhere(['<', 'start', $end->format('Y-m-d H:i:s')])
            ->andWhere(['storeId' => $data['storeId']])
            ->orderBy(['start' => 'asc'])
            ->all();
        $pendingState = ShiftState::findOne([
            'name' => ShiftState::STATE_PENDING
        ]);
        //$shiftId = \Yii::$app->request->get('shiftId');

        foreach ($shifts as $shift) {
            // Convert to store local timezone
            $startDateTime = new \DateTime($shift->start);
            $startDateTime = TimezoneHelper::convertFromUTC($timezone, $startDateTime);
            $endDateTime = new \DateTime($shift->end);
            $endDateTime = TimezoneHelper::convertFromUTC($timezone, $endDateTime);

            $applicantsCount = 0;
            if ($shift->shiftStateId == $pendingState->id) {
                $applicantsCount = count($shift->applicants);
            }
            // delivery count
            $driverdeliverycount = $shift->deliveryCount;
            $lastdriverrequest = $shift->LastDriverShiftRequestReview;
            if($lastdriverrequest){
                $driverdeliverycount=$lastdriverrequest->deliveryCount;
            }
            

            $active = "";
            //$active = ($shift->id == $shiftId) ? " active" : "";

//            $now = date("Y-m-d H:i:s");
//            $time = strtotime($now);
//            $time = $time - (30 * 60);
//            $startDate = date("Y-m-d H:i:s", $time);
//
//            if($startDateTime<$startDate && $shift->shiftStateId == $pendingState->id ){
//                // ignore unused shifts
//            }else{

            $result[] = [
                'date'  => $startDateTime->format('Y-m-d'),
                'begin' => $startDateTime->format('H:i'),
                'end'   => $endDateTime->format('H:i'),
                'title' =>  '',
                'id'    => $shift->id,
                'data'  => [
                    'url' => Url::to([
                        'shifts-calendar/shift-view', 
                        'shiftId' => $shift->id
                    ]),
                    'shiftStateId' => $shift->shiftStateId,
                    'color' => $shift->shiftState->color . $active
                ],
                'applicantsCount' => $applicantsCount,
                'driverDeliveryCount'=>$driverdeliverycount,
            ];
//            }
        }
        return $result;
    }
}