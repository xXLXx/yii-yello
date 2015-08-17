<?php

namespace frontend\widgets\DriverList;

use frontend\widgets\BaseGridView;

/**
 * Driver list widget
 *
 * @author alex
 */
class DriverListWidget extends BaseGridView
{
    public function init()
    {
        $this->columns = $this->_getColumns();
        parent::init();
    }

    public $layout = "{items}\n{pager}";

    public $pager = [
        'class' => 'frontend\widgets\DriverList\DriverLinkPager'
    ];
    /**
     * Get columns
     *
     * @return array
     */
    public function _getColumns()
    {
        return [
            [
                'label' => \Yii::t('app', 'Driver'),
                'format' => 'raw',
                'value' => function ($driver) {
                  return $this->render('blocks/driverColumn', [
                        'driver' => $driver
                    ]);
                },
                'headerOptions' => ['style'=>'font-weight: 600'],
            ],
            [
                'label' => \Yii::t('app', 'Payments'),
                'value' => function ($driver) {
                    return !empty($driver->payments) ? $driver->payments : '';
                },
                'headerOptions' => ['style'=>'font-weight: 600']
            ],
            [
                'label' => \Yii::t('app', 'Vehicle'),
                'value' => function ($driver) {
                    return $driver->vehicle ? $driver->vehicle->vehicleType->title : '';
                },
                'headerOptions' => ['style'=>'font-weight: 600']
            ],
            /*[
                'label' => \Yii::t('app', 'Availability'),
                'format' => 'html',
                'value' => function ($driver) {
                    return $driver->userDriver ? $driver->userDriver->availability : '';
                },
                'headerOptions' => ['style'=>'font-weight: 600']
            ],*/
            [
                'label' => \Yii::t('app', 'Achievements'),
                'format' => 'html',
                'value' => function ($driver) {
                    return $this->render('blocks/achivementsColumn', [
                        'driver' => $driver
                    ]);
                },
                'headerOptions' => ['style'=>'font-weight: 600']
            ],
            /*[
                'label' => \Yii::t('app', 'Locations'),
                'format' => 'html',
                'value' => function ($driver) {
                    return $this->render('blocks/locationsColumn', [
                        'driver' => $driver
                    ]);
                },
                'headerOptions' => ['style'=>'font-weight: 600']
            ],*/
            [
                'format' => 'html',
                'value' => function ($driver) {
                    return $this->render('blocks/infoColumn', [
                        'driver' => $driver
                    ]);
                },
                'headerOptions' => ['style'=>'font-weight: 600']
            ]
        ];
    }
}