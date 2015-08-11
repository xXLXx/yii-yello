<?php

namespace frontend\controllers;

use common\models\Driver;
use common\models\DriverHasStore;
use common\models\search\DriverSearch;
use common\models\ShiftReviews;
use common\models\ShiftState;
use common\models\Shift;
use frontend\models\StoreInviteDriverForm;
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

        //$storeOwner = \Yii::$app->user->getIdentity()->storeOwner;

        if (!isset($searchParams['category'])) {
            $searchParams['category'] = "all";
        }

        $searchModel = new DriverSearch();
        $dataProvider = $searchModel->search($searchParams);
        $driversCount = $dataProvider->count;

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
     * Invite driver to store
     *
     * @return string
     */
    public function actionInvite()
    {
        $post = \Yii::$app->request->post();
        $driver = Driver::findOne($post['driverId']);

        ///$storeHasDriver = ::findOne($post['driverId']);
        if (!$driver || DriverHasStore::isInvited($driver->id)) {
            return Json::encode([
                'success' => false
            ]);
        }

        $storeInviteDriverForm = new StoreInviteDriverForm();
        $params['StoreInviteDriverForm']['driverId'] = $post['driverId'];
        if ($storeInviteDriverForm->load($params)) {

            if ($storeInviteDriverForm->validate()) {

                $storeInviteDriverForm->save();

                return Json::encode([
                    'success' => true
                ]);
            }
        }

        return Json::encode([
            'success' => false
        ]);
    }

    /**
     * Disconnect driver from store
     *
     * @return string
     */
    public function actionDisconnect()
    {
        $post = \Yii::$app->request->post();
        $driver = Driver::findOne($post['driverId']);

        ///$storeHasDriver = ::findOne($post['driverId']);
        if (!$driver || !DriverHasStore::isInvited($driver->id)) {
            return Json::encode([
                'success' => false
            ]);
        }



        $user = \Yii::$app->user->identity;
        $storeId = $user->storeOwner->storeCurrent->id;

        $driverHasStore = DriverHasStore::findOne(
            [
                'storeId' => $storeId,
                'driverId' => $driver->id
            ]
        );
        $driverHasStore->delete();

        return Json::encode([
            'success' => true
        ]);
    }



    /**
     * Remove driver from favourites
     *
     * @return string  
     * 
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
        if (!$driver->userDriver) {
            return false;
        }

        $connected = DriverHasStore::isConnected($id);
        $invited = DriverHasStore::isInvited($id);

        $completedShiftState = ShiftState::findOne(['name' => ShiftState::STATE_COMPLETED]);
        //TODO: Lalit - please comment changes
        $completedShift = Shift::findAll(['shiftStateId' => $completedShiftState->id]);
        $shiftData = Shift::find()
            ->where(['shiftStateId' => $completedShiftState->id])
            ->andWhere(['driverId' => $id])
            ->select(['Shift.id, sum(deliveryCount) as deliveriesCount', 'count(Shift.id) as completedShift'])
            ->leftJoin('shifthasdriver as shiftHasDriver', 'Shift.id=shiftHasDriver.shiftId')
            ->asArray()
            ->one();

        $reviews = ShiftReviews::find()
            ->with('store')
            ->where(['driverId' => $id])
            ->all();

        $review_sum = 0;
        foreach($reviews as $review){
            $review_sum += $review['stars'];
        }
        $review_avg = 0;
        if(count($reviews)){
            $review_avg = $review_sum / count($reviews);
        }

        return $this->render('profile', [
            'driver' => $driver,
            'completedShiftCount' => $shiftData['completedShift'],
            'deliveriesCount' => $shiftData['deliveriesCount'] ?: 0,
            'reviews' => $reviews,
            'review_avg' => $review_avg,
            'connected' => $connected,
            'invited' => $invited
        ]);

    }
}