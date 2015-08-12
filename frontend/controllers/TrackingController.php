<?php

namespace frontend\controllers;

use common\models\User;
use yii\helpers\ArrayHelper;

/**
 * Driver Map Controller
 *
 * @author -xXLXx-
 */
class TrackingController extends BaseController
{
    /**
     * Map
     */
    public function actionIndex()
    {
        $storeOwner = \Yii::$app->user->getIdentity()->storeOwner;
        $currentStore = $storeOwner->getStoreCurrent();
        $store = [
            'id' => $currentStore->id,
            'position' => [$currentStore->address->latitude, $currentStore->address->longitude]
        ];

        $drivers = User::find()
            ->joinWith(['driverHasStores'])
            ->andFilterWhere([
                'DriverHasStore.storeId' => $storeOwner->getStoreCurrent()->id,
                'DriverHasStore.isAcceptedByDriver' => 1
            ])
            ->all();
        $drivers = ArrayHelper::toArray($drivers);

        return $this->render('index', compact('drivers', 'store'));
    }
}
