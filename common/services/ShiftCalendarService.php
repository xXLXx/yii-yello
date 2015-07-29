<?php

namespace common\services;

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
        $shifts = Shift::find()
            ->with('applicants')
            ->andWhere(['>=', 'start', $data['start']])
            ->andWhere(['<=', 'end', $data['end']])
            ->andWhere(['storeId' => $data['storeId']])
            ->orderBy(['start' => 'asc'])
            ->all();
        $pendingState = ShiftState::findOne([
            'name' => ShiftState::STATE_PENDING
        ]);
        //$shiftId = \Yii::$app->request->get('shiftId');

        foreach ($shifts as $shift) {
            $startDateTime = 
                \DateTime::createFromFormat('Y-m-d H:i:s', $shift->start);
            $endDateTime = 
                \DateTime::createFromFormat('Y-m-d H:i:s', $shift->end);
            $applicantsCount = 0;
            if ($shift->shiftStateId == $pendingState->id) {
                $applicantsCount = count($shift->applicants);
            }

            $active = "";
            //$active = ($shift->id == $shiftId) ? " active" : "";

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
                'applicantsCount' => $applicantsCount
            ];
        }
        return $result;
    }
}
