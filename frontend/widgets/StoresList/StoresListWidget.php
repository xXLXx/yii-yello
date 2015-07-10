<?php
/**
 * Created by PhpStorm.
 * User: KustovVA
 * Date: 25.06.2015
 * Time: 17:35
 */

namespace frontend\widgets\StoresList;


use common\models\Store;
use frontend\widgets\BaseGridView;
use yii\helpers\Html;

class StoresListWidget extends BaseGridView {
    public $layout = "{items}\n{pager}";
    public $pager = [
        'class' => 'frontend\widgets\StoresList\StoresListPager'
    ];

    public function init()
    {
        $this->columns = [
            [
                'label' => \Yii::t('app', 'Store'),
                'format' => 'html',
                'value' => function (Store $store) {
//                    return $store->title;
                    return $this->render('blocks/storeColumn', [
                        'store' => $store
                    ]);
                },
                'headerOptions' => ['style'=>'font-weight: 600'],
            ],
            [
                'label' => \Yii::t('app', 'Schedule'),
                'value' => function (Store $store) {
                    return 'TESTDATA';
                },
                'headerOptions' => ['style'=>'font-weight: 600']
            ],
            [
                'label' => \Yii::t('app', 'Company'),
                'value' => function (Store $store) {
                    return $store->companyId ? $store->company->companyName : '';
                },
                'headerOptions' => ['style'=>'font-weight: 600']
            ],
            [
                'label' => \Yii::t('app', 'Contact'),
                'format' => 'html',
                'value' => function (Store $store) {
                    return $store->contactPerson ? $store->contactPerson : '';
                },
                'headerOptions' => ['style'=>'font-weight: 600']
            ],
            [
                'label' => \Yii::t('app', 'Phone'),
                'format' => 'html',
                'value' => function (Store $store) {
                    return $store->phone;
                },
                'headerOptions' => ['style'=>'font-weight: 600']
            ],
            [
                'label' => \Yii::t('app', 'Address'),
                'format' => 'html',
                'value' => function (Store $store) {
                    return $store->address1;
                },
                'headerOptions' => ['style'=>'font-weight: 600']
            ],
            [
                'label' => false,
                'format' => 'html',
                'value' => function(Store $store) {
                    return $this->render('blocks/storeActions', [
                        'store' => $store
                    ]);
                },
                'headerOptions' => ['class' => 'info-button-cell'],
            ]
        ];
        parent::init();
    }



}