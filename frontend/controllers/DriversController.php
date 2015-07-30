<?php

namespace frontend\controllers;

use common\models\Driver;
use common\models\search\DriverSearch;
use common\models\ShiftRequestReview;
use common\models\ShiftState;
use common\models\Shift;
use yii\helpers\Json;

/**
 * Driver list controller
 *
 * @author alex
 */
class DriversController extends BaseController
{
    /**
     * Page list of drivers
     */
    public function actionIndex()
    {
        $searchParams = \Yii::$app->request->getQueryParams();
        $searchModel = new DriverSearch();
        $dataProvider = $searchModel->search($searchParams);
        $driversCount = Driver::find()->count();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'driversCount' => $driversCount,
            'searchParams' => $searchParams
        ]);
    }

    /**
     * Add driver to favourites
     *
     * @return string
     */
    public function actionAddFavourite()
    {
        $post = \Yii::$app->request->post();
        $storeOwner = \Yii::$app->user->getIdentity()->storeOwner;
        $storeOwnerId = $storeOwner->id;
        $driver = Driver::findOne($post['driverId']);
        if (!$driver || $driver->favouriteForStoreOwner($storeOwnerId)) {
            return Json::encode([
                'success' => false
            ]);
        }
        $storeOwner->addFavouriteDriver($driver->id);
        return Json::encode([
            'success' => true
        ]);
    }

    /**
     * Remove driver from favourites
     *
     * @return string
     */
    public function actionRemoveFavourite()
    {
        $post = \Yii::$app->request->post();
        $storeOwner = \Yii::$app->user->getIdentity()->storeOwner;
        $storeOwnerId = $storeOwner->id;
        $driver = Driver::findOne($post['driverId']);
        if (!$driver || !$driver->favouriteForStoreOwner($storeOwnerId)) {
            return Json::encode([
                'success' => false
            ]);
        }
        $storeOwner->removeFavouriteDriver($driver->id);
        return Json::encode([
            'success' => true
        ]);
    }

    public function actionProfile($id)
    {
        $driver = Driver::findOne($id);
        if (!$driver->userDriver)
        {
            return false;
        }
        $completedShiftState = ShiftState::findOne(['name' => ShiftState::STATE_COMPLETED]);
        $completedShift = Shift::findAll(['shiftStateId' => $completedShiftState->id]);
        $shiftData = Shift::find()
            ->where(['shiftStateId' => $completedShiftState->id])
            ->andWhere(['driverId' => $id])
            ->select(['Shift.id, sum(deliveryCount) as deliveriesCount', 'count(Shift.id) as completedShift'])
            ->leftJoin('shifthasdriver as shiftHasDriver', 'Shift.id=shiftHasDriver.shiftId')
            ->asArray()
            ->one();

        //$deliveriesCount = 10;
        $reviews = ShiftRequestReview::find()->all();
        return $this->render('profile', [
            'driver' => $driver,
            'completedShiftCount' => $shiftData['completedShift'],
            'deliveriesCount' => $shiftData['deliveriesCount'] ?: 0,
            'reviews' => $reviews
        ]);

    }
}