<?php

namespace frontend\controllers;

use common\models\Driver;
use common\models\DriverHasStore;
use common\models\Image;
use common\models\Note;
use common\models\search\DriverSearch;
use common\models\ShiftReviews;
use common\models\ShiftState;
use common\models\Shift;
use common\models\User;
use common\models\UserDriver;
use frontend\models\NoteForm;
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

        $driver = Driver::findOne($post['driverId']);
        if (!$driver || $driver->favouriteForCurrentStore()) {
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
        $driver = Driver::findOne($post['driverId']);
        if (!$driver || !$driver->favouriteForCurrentStore()) {
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

        $user = \Yii::$app->user->identity;
        $storeId = $user->storeOwner->storeCurrent->id;
        $driverHasStore = DriverHasStore::find(['driverId' => $id, 'storeId' => $storeId])->one();

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

        $user = \Yii::$app->user->identity;
        $storeId = $user->storeOwner->storeCurrent->id;

        $note = Note::findOne(['driverId' => $id, 'storeId' => $storeId]);

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
            'invited' => $invited,
            'note' => $note,
            'driverHasStore' => $driverHasStore
        ]);

    }

    /**
     * Form for add Note
     */
    public function actionNote($driverId = "")
    {
        $this->layout = 'empty';
        $noteForm = new NoteForm();
        $errors = array();

        $noteForm->note = $noteForm->currentNote;


        $params = \Yii::$app->request->post();
        if ($noteForm->load($params)) {
            if ($noteForm->validate()) {
                $noteForm->save();
                $message = '<div>
                success
                <div class="success_message">'.$noteForm->note.'</div>
                </div>';
                return $message;
            }else{
                $driverId = $params['NoteForm']['driverId'];
                $errors = $noteForm->getErrors();
            }
        }

        return $this->render('addNoteForm', [
            'model' => $noteForm,
            'driverId' => $driverId,
            'errors' => $errors
        ]);
    }

    /**
     * Delete driver note
     *
     * @return string
     */
    public function actionRemoveNote($id)
    {
        $user = \Yii::$app->user->identity;
        $storeId = $user->storeOwner->storeCurrent->id;

        $driverNote = Note::findOne(
            [
                'storeId' => $storeId,
                'driverId' => $id
            ]
        );
        $driverNote->delete();

        return Json::encode([
            'success' => true
        ]);
    }

    /**
     * Rotate Photo By 90deg clockwise.
     *
     * @return string
     */
    public function actionRotatePhoto()
    {
        $user = \Yii::$app->user->identity;

        $driver = Driver::findOne(43);

        $url = $driver->vehicle->licensePhoto->originalUrl;

        if($url){
            $path = \Yii::$app->basePath;
            $this->rotate_photo($path.'\web'.$url, 90);

            return Json::encode([
                'success' => true
            ]);
        } else {
            return Json::encode([
                'success' => false
            ]);
        }
    }

    public function rotate_photo($rotateFilename, $degrees){

        $fileType = strtolower(substr($rotateFilename, strrpos($rotateFilename, '.') + 1));

        if($fileType == 'png' || $fileType == 'PNG'){
            header('Content-type: image/png');
            $source = imagecreatefrompng($rotateFilename);
            $bgColor = imagecolorallocatealpha($source, 255, 255, 255, 127);
            // Rotate
            $rotate = imagerotate($source, $degrees, $bgColor);
            imagesavealpha($rotate, true);
            imagepng($rotate,$rotateFilename);

        }

        if($fileType == 'jpg' || $fileType == 'jpeg'){
            header('Content-type: image/jpeg');
            $source = imagecreatefromjpeg($rotateFilename);
            // Rotate
            $rotate = imagerotate($source, $degrees, 0);
            imagejpeg($rotate,$rotateFilename);
        }

        // Free the memory
        imagedestroy($source);
        imagedestroy($rotate);

    }

    public function actionChangePaymentMethod($driverId){

        $this->layout = 'empty';
        $storeInviteDriverForm = new StoreInviteDriverForm();
        $storeInviteDriverForm->driverId = $driverId;
        $params = \Yii::$app->request->post();

        $driver = Driver::find()->where(['id' => $driverId])->one();

        $user = \Yii::$app->user->identity;
        $storeId = $user->storeOwner->storeCurrent->id;
        $driverHasStore = DriverHasStore::find(['driverId' => $driverId, 'storeId' => $storeId])->one();

        if ($storeInviteDriverForm->load($params)) {

            $driverHasStore->storeRequestedMethod = $params['storeInviteDriverForm']['storeRequestedMethod'];
            if($driverHasStore->paymentMethod == $driverHasStore->storeRequestedMethod){
                return "<div><div class='success_message'>Payment method is already set as ".$driverHasStore->storeRequestedMethod.".</div></div>";
            } else {
                $driverHasStore->save();
                return "<div><div class='success_message'>Your request for change payment method is sent.</div></div>";
            }

        }

        return $this->render('change-payment-method', [
            'storeInviteDriverForm' => $storeInviteDriverForm,
            'driverHasStore' => $driverHasStore,
            'driver' => $driver
        ]);
    }

    public function actionCancelPaymentChange($driverId){

        $params = \Yii::$app->request->post();

        if(count($params)){

            $user = \Yii::$app->user->identity;
            $storeId = $user->storeOwner->storeCurrent->id;
            $driverHasStore = DriverHasStore::find(['driverId' => $driverId, 'storeId' => $storeId])->one();

            if($driverHasStore){
                $driverHasStore->storeRequestedMethod = '';
                $driverHasStore->save();
                return Json::encode([
                    'success' => 'Successfully cancelled the change payment request.'
                ]);
            } else {
                return Json::encode([
                    'success' => false
                ]);
            }

        } else {

            $this->layout = false;
            $driver = Driver::find()->where(['id' => $driverId])->one();

            return $this->render('cancel-payment-change',[
                'driver' => $driver
            ]);
        }

    }

}