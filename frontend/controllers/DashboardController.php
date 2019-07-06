<?php

namespace frontend\controllers;
use common\models\ShiftState;
use common\models\Shift;
use common\models\Driver;
use common\models\StoreOwnerFavouriteDrivers;
use common\models\DriverHasStore;
use common\models\ShiftHasDriver;
use common\models\User;
use yii\web\JsExpression;

/**
 * Dashboard page controller
 *
 * @author alex
 */
class DashboardController extends BaseController
{   
    private static $_ranges;

    public function beforeAction($action)
    {
        $ranges = ['today', 'yesterday', 'week', 'month', 'quarter', 'year'];
        self::$_ranges = array_combine($ranges, $ranges);

        return parent::beforeAction($action);
    }

    /**
     * Get the timeline headers displayed on Dashboard
     *
     * @param $range string range request parameter
     * @param $enddate int UTC reference for range
     */
    private function getTimeline($range, $enddate)
    {
        $timeline = [];

        if ($range == self::$_ranges['today'] || $range == self::$_ranges['yesterday']) {
            if ($range == self::$_ranges['yesterday']) {
                $enddate -= 3600 * 24;
            }
            for ($x = 1; $x <= 12; $x++) {
                $enddate += 3600 * 2;
                if ($x == 12) {
                    $enddate -= 1;
                }
                $timeline[] = [
                    'label'     => date('h:iA', $enddate),
                    'value'     => date('Y-m-d H:i:s', $enddate),
                    'graphDate' => date('Y-m-d H:i:s', $enddate)
                ];
            }
        } else if ($range == self::$_ranges['week']) {
            $startdate = $enddate - 24 * 3600 * 6;
            while ($startdate <= $enddate) {
                if ($startdate == $enddate) {
                    $startdate += 24 * 3600 - 1;
                }
                $timeline[] = [
                    'label' => date('d.m.y', $startdate),
                    'value' => date('Y-m-d H:i:s', $startdate),
                    'graphDate' => date('Y-m-d 00:00:00', $startdate)
                ];
                $startdate += 24 * 3600;
            }
        } else if ($range == self::$_ranges['month']) {
            $startdate = strtotime('-1 month', $enddate);
            $start = true;
            $end = false;
            while ($startdate <= $enddate) {
                if ($startdate == $enddate) {
                    $startdate += 24 * 3600 - 1;
                    $end = true;
                }
                $data = [
                    'value' => date('Y-m-d H:i:s', $startdate),
                    'graphDate' => date('Y-m-d 00:00:00', $startdate)
                ];
                if ($start || $end) {
                    $data['label'] = date('d.m.y', $startdate);
                }
                $timeline[] = $data;
                $startdate += 24 * 3600;

                $start = false;
            }
        } else if ($range == self::$_ranges['quarter']) {
            $startdate = strtotime('-2 month', $enddate);
            while ($startdate <= $enddate) {
                if ($startdate == $enddate) {
                    $startdate += 24 * 3600 - 1;
                }
                $timeline[] = [
                    'label' => date('d.m.y', $startdate),
                    'value' => date('Y-m-d H:i:s', $startdate),
                    'graphDate' => date('Y-m-d 00:00:00', $startdate)
                ];
                $startdate = strtotime('+1 month', $startdate);
            }
        } else if ($range == self::$_ranges['year']) {
            $startdate = strtotime('-12 month', $enddate);
            while ($startdate <= $enddate) {
                if ($startdate == $enddate) {
                    $startdate += 24 * 3600 - 1;
                }
                $timeline[] = [
                    'label' => date('d.m.y', $startdate),
                    'value' => date('Y-m-d H:i:s', $startdate),
                    'graphDate' => date('Y-m-d 00:00:00', $startdate)
                ];
                $startdate = strtotime('+1 month', $startdate);
            }
        } else {
            $timeline = $this->getTimeline('week', $enddate);
        }

        return $timeline;
    }

    /**
     * Gets the timeline data to dispaly on Dashboard
     *
     * @param $query yii\db\ActiveQuery base query to use for finding data
     * @param $dateKey string column to use as reference for range
     * @param $dataKey string column to use for summing up data, set to null to add 1 for each row
     * @param $range string range request parameter
     * @param $enddate int UTC reference for range
     * @param $timeline array dates to traverse for summing up data
     */
    private function getTimelineData($query, $dateKey, $dataKey, $range, $enddate, $timeline = [])
    {
        $data = $query
            ->ofCurrentStore()
            ->andWhere($this->getRangeCondition($range, $enddate, $dateKey))
            ->orderBy($dateKey)
            ->all();
        $timelineData = [
            ['Date', '']
        ];
        $x = 0;
        foreach ($data as $item) {
            while ($timeline[$x]) {
                $itemData = 0;
                $break = false;

                if ($timeline[$x]['value'] >= $item->{$dateKey}) {
                    $itemData = empty($item->{$dataKey}) ? 1 : (int) $item->{$dataKey};
                    $break = true;
                }

                // Always add 1 for array's first row of items w/c is the header
                if (isset($timelineData[$x + 1])) {
                    $timelineData[$x + 1][1] += $itemData;
                } else {
                    $timelineData[] = [new JsExpression('new Date("' . $timeline[$x]['graphDate'] . '")'), $itemData];
                }

                if ($break) {
                    break;
                } else {
                    $x++;
                }
            }
        }
        while ($x < count($timeline)) {
            $timelineData[] = [new JsExpression('new Date("' . $timeline[$x]['graphDate'] . '")'), 0];
            $x++;
        }

        return $timelineData;
    }

    /**
     * Gets the number of days from a specific range
     *
     * @param $query yii\db\ActiveQuery base query to use for finding data
     * @param $dateKey string column to use as reference for range
     */
    private function getNoOfDays($query, $dateKey)
    {
        $dataFirst = $query->orderBy([$dateKey => SORT_ASC])->one();
        $dataLast = $query->orderBy([$dateKey => SORT_DESC])->one();

        if (empty($dataFirst) || empty($dataLast)) {
            return 1;
        }

        return floor((strtotime($dataLast->{$dateKey}) - strtotime($dataFirst->{$dateKey})) / 3600 / 24) ?: 1;
    }

    /**
     * Get condition to add to where, used to filter data within the range
     *
     * @param $range string range request parameter
     * @param $enddate int UTC reference for range
     * @param $dateKey string column to use as reference for range
     */
    private function getRangeCondition($range, $enddate, $dateKey)
    {
        if ($range == self::$_ranges['today'] || $range == self::$_ranges['yesterday']) {
            if ($range == self::$_ranges['yesterday']) {
                $enddate -= 3600 * 24;
            }
            return [
                "SUBSTR($dateKey, 1, 10)" => date('Y-m-d', $enddate)
            ];
        } else if ($range == self::$_ranges['week']) {
            $startdate = $enddate - 24 * 3600 * 6;
            return ['BETWEEN', "$dateKey", date('Y-m-d H:i:s', $startdate), date('Y-m-d 11:59:59', $enddate)];
        } else if ($range == self::$_ranges['month']) {
            $startdate = strtotime('-1 month', $enddate);
            return ['BETWEEN', "$dateKey", date('Y-m-d H:i:s', $startdate), date('Y-m-d 11:59:59', $enddate)];
        } else if ($range == self::$_ranges['quarter']) {
            $startdate = strtotime('-2 month', $enddate);
            return ['BETWEEN', "$dateKey", date('Y-m-d H:i:s', $startdate), date('Y-m-d 11:59:59', $enddate)];
        } else if ($range == self::$_ranges['year']) {
            $startdate = strtotime('-11 month', $enddate);
            return ['BETWEEN', "$dateKey", date('Y-m-d H:i:s', $startdate), date('Y-m-d 11:59:59', $enddate)];
        }

        return $this->getRangeCondition('today', $enddate, $dateKey);
    }

    /**
     * Dashboard page
     */
    public function actionIndex()
    {
        $enddate = \Yii::$app->request->get('enddate') ?: date('Y-m-d');
        $enddateutc = strtotime($enddate);
        $range = \Yii::$app->request->get('range') ?: 'week';
        $storeId = \Yii::$app->user->identity->storeOwner->storeCurrent->id;

        // Shifts Pie Chart
        $shifts = Shift::find()->ofCurrentStore()->andWhere($this->getRangeCondition($range, $enddateutc, 'end'))->all();
        $completedShifts = Shift::find()->completed()->ofCurrentStore()->andWhere($this->getRangeCondition($range, $enddateutc, 'end'))->all();
        $pendingShifts = Shift::find()->pending()->ofCurrentStore()->andWhere($this->getRangeCondition($range, $enddateutc, 'end'))->all();
        $yelloAllocatedShifts = Shift::find()->yelloAllocated()->ofCurrentStore()->andWhere($this->getRangeCondition($range, $enddateutc, 'end'))->all();
        $allocatedShifts = Shift::find()->allocated()->ofCurrentStore()->andWhere($this->getRangeCondition($range, $enddateutc, 'end'))->all();
        $shiftItems = [
            [
                'title' => 'Pending',
                'count' => count($pendingShifts),
                'color' => 'pink',
                'class' => 'red'
            ],
            [
                'title' => 'Completed',
                'count' =>  count($completedShifts),
                'color' => 'green',
                'class' => 'green'
            ],
            [
                'title' => 'Allocated Yello',
                'count' => count($yelloAllocatedShifts),
                'color' => 'yellow',
                'class' => 'yellow'
            ],
            [
                'title' => 'Allocated',
                'count' => count($allocatedShifts),
                'color' => '#e4e7ea'
            ],
        ];

        // Drivers Pie Chart
        $drivers = Driver::find()->innerJoinWith('acceptedShifts')->andWhere($this->getRangeCondition($range, $enddateutc, 'end'))->all();
        $favouriteDrivers = StoreOwnerFavouriteDrivers::find()->ofCurrentStore()->innerJoinWith('driver.acceptedShifts')->andWhere($this->getRangeCondition($range, $enddateutc, 'end'))->all();
        $storeDrivers = DriverHasStore::find()->ofCurrentStore()->innerJoinWith('driver.acceptedShifts')->andWhere($this->getRangeCondition($range, $enddateutc, 'end'))->all();
        $favouriteDriversCount = 0;
        $storeDriversCount = 0;
        // Remove intersections for these groups
        foreach ($favouriteDrivers as $favouriteDriver) {
            // Remove all stroreDrivers in favourites
            foreach ($storeDrivers as $key => $storeDriver) {
                if ($favouriteDriver->driverId == $storeDriver->driverId) {
                    unset($storeDrivers[$key]);
                    break;
                }
            }
            // Remove all yelloDrivers in favourites
            foreach ($drivers as $key => $driver) {
                if ($favouriteDriver->driverId == $driver->id) {
                    unset($drivers[$key]);
                    break;
                }
            }
            $favouriteDriversCount++;
        }
        // Remove all yello drivers in storeDrivers
        foreach ($storeDrivers as $storeDriver) {
            foreach ($drivers as $key => $driver) {
                if ($storeDriver->driverId == $driver->id) {
                    unset($drivers[$key]);
                    break;
                }
            }
            $storeDriversCount++;
        }
        $driverItems = [
            [
                'title' => 'Favorite Drivers',
                'count' => $favouriteDriversCount,
                'color' => 'blue',
                'class' => 'blue'
            ],
            [
                'title' => 'Yello Drivers',
                'count' => count($drivers),
                'color' => 'yellow',
                'class' => 'yellow'
            ],
            [
                'title' => 'Store drivers',
                'count' => $storeDriversCount,
                'color' => '#e4e7ea',
            ]
        ];
        $shiftCount = count($shifts);
        $driverCount = count($drivers) + $favouriteDriversCount + $storeDriversCount;

        // For Line graph
        $timeline = $this->getTimeline($range, $enddateutc);

        $paidData = $this->getTimelineData(Shift::find(), 'end', 'payment', $range, $enddateutc, $timeline, true);

        $applicationsData = $this->getTimelineData(Shift::find()
            ->innerJoinWith('shiftHasDrivers')
            ->select([
                '*',
                'applicantsCount' => 'COUNT(' . ShiftHasDriver::tableName() .'.driverId)'
            ])
            ->groupBy(Shift::tableName() . '.id'),
        'end', 'applicantsCount', $range, $enddateutc, $timeline);

        $deliveriesData = $this->getTimelineData(Shift::find(), 'end', 'deliveryCount', $range, $enddateutc, $timeline);

        $shiftsBookedData = $this->getTimelineData(Shift::find(), 'end', NULL, $range, $enddateutc, $timeline);

        $shiftNoOfDays = $this->getNoOfDays(Shift::find()->ofCurrentStore()->andWhere($this->getRangeCondition($range, $enddateutc, 'end')), 'end');
        $paidCount = $paidShifts = Shift::find()->ofCurrentStore()->andWhere($this->getRangeCondition($range, $enddateutc, 'end'))->sum('payment');
        $paid = \Yii::$app->formatter->asCurrency($paidCount ?: 0);
        $paidAverage = \Yii::$app->formatter->asCurrency(round($paidCount / $shiftNoOfDays));
        $applications = Shift::find()
            ->innerJoinWith('shiftHasDrivers')
            ->andWhere($this->getRangeCondition($range, $enddateutc, 'end'))
            ->count(ShiftHasDriver::tableName() .'.driverId');
        $deliveries = Shift::find()->ofCurrentStore()->andWhere($this->getRangeCondition($range, $enddateutc, 'end'))->sum('deliveryCount');
        $deliveriesAverage = round($deliveries / $shiftNoOfDays, 2);
        $shiftsBooked = Shift::find()->ofCurrentStore()->andWhere($this->getRangeCondition($range, $enddateutc, 'end'))->count();
        $shiftsBookedAverage = round($shiftsBooked / $shiftNoOfDays, 2);

        return $this->render('index', compact(
            'shiftCount',
            'driverCount',
            'shiftItems',
            'driverItems',
            'paid',
            'paidAverage',
            'applications',
            'deliveries',
            'deliveriesAverage',
            'shiftsBooked',
            'shiftsBookedAverage',
            'enddate',
            'range',
            'paidData',
            'applicationsData',
            'deliveriesData',
            'shiftsBookedData',
            'timeline'
        ));
    }
}