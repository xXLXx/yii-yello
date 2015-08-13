<?php

namespace common\services;

use common\models\Shift;
use common\models\ShiftCopyLog;
use common\models\ShiftHasDriver;
use common\models\ShiftState;

/**
 * Shift copy service
 *
 * @author markov
 */
class ShiftCopyService extends BaseService
{
    /**
     * Copy
     * 
     * @param array $params params
     */
    public static function copy($params)
    {
        $hashParams = [
            $params['start'],
            $params['end'],
            $params['storeId'],
            $params['period']
        ];
        $hash = md5(implode('/', $hashParams));
        $shifts = Shift::find()
            ->andWhere(['>=', 'start', $params['start']])
            ->andWhere(['<', 'end', $params['end']])
            ->andWhere(['storeId' => $params['storeId']])
                ->all();
        $logShiftIds = ShiftCopyLog::find()
            ->select('shiftId')
            ->andWhere(['hash' => $hash])
                ->column();

        foreach ($shifts as $shift) {
            if (in_array($shift->id, $logShiftIds)) {
                continue;
            }
            
            $shiftCopy = new Shift();
            $shiftCopy->setAttributes($shift->getAttributes());
            $shiftCopy->setStateByName(ShiftState::STATE_PENDING);
            $shiftCopy->actualStart = null;
            $shiftCopy->actualEnd = null;
            $shiftCopy->deliveryCount = 0;
            $shiftCopy->payment = 0;
            $start = \DateTime::createFromFormat(
                'Y-m-d H:i:s', $shift->start
            );
            $start->add(new \DateInterval($params['period']));
            $shiftCopy->start = $start->format('Y-m-d H:i:s');
            $end = \DateTime::createFromFormat(
                'Y-m-d H:i:s', $shift->end
            );
            $end->add(new \DateInterval($params['period']));
            $shiftCopy->end = $end->format('Y-m-d H:i:s');
            $shiftCopy->save();

            // Assign to the same drivers
            if ($params['assign'] && $shift->driverAccepted) {
                $shiftHasDriver = new ShiftHasDriver([
                    'shiftId' => $shiftCopy->id,
                    'driverId' => $shift->driverAccepted->id
                ]);
                $shiftHasDriver->save();
            }
            
            $shiftCopyLog = new ShiftCopyLog();
            $shiftCopyLog->shiftId = $shift->id;
            $shiftCopyLog->shiftCopyId = $shiftCopy->id;
            $shiftCopyLog->hash = $hash;
            $shiftCopyLog->save();
        }
    }

    /**
     * Confirms a roster.
     * Mark ShiftCopyLog.confirmedAt with current timestamp
     * and ShiftHadDriver.acceptedByStoreOwner as true.
     *
     * @param array $params
     *
     * @return int number of confirmed drivers
     */
    public static function confirm($params)
    {
        $shifts = Shift::find()
            ->andWhere(['>=', 'start', $params['start']])
            ->andWhere(['<', 'end', $params['end']])
            ->andWhere(['storeId' => $params['storeId']])
            ->joinWith('shiftCopyLog', true, 'RIGHT JOIN') // so we dont waste getting other records
            ->joinWith('shiftHasDrivers', true, 'RIGHT JOIN') // and with assigned driver
            ->all();

        $confirmedDrivers = 0;
        foreach ($shifts as $shift) {
            $shift->shiftCopyLog->confirmedAt = time();
            $shift->shiftCopyLog->save(false);

            foreach ($shift->shiftHasDrivers as $shiftDriver) {
                $shiftDriver->acceptedByStoreOwner = 1;
                $shiftDriver->save(false);
                $confirmedDrivers++;
            }
        }

        return $confirmedDrivers;
    }
}
