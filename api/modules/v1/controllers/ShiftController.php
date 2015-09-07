<?php
/**
 * v1-specific restful Shift controller
 */

namespace api\modules\v1\controllers;

use api\modules\v1\filters\Auth;
use api\modules\v1\models\Shift;
use common\models\search\ShiftSearch;
use common\models\ShiftHasDriver;
use common\models\Shiftsavailable;
use yii\data\ActiveDataProvider;
use yii\web\BadRequestHttpException;

/**
 * Class ShiftController
 * @package api\modules\v1\controllers
 *
 * @method Shift findModel(string $id)
 */

class ShiftController extends \api\common\controllers\ShiftController
{
    /**
     * @inheritdoc
     */
    public $modelClass = 'api\modules\v1\models\Shift';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => Auth::className(),
        ];
        return $behaviors;
    }

    /**
     * @return null|\yii\web\IdentityInterface
     */
    public function actionCheck()
    {
        $user = \Yii::$app->user->getIdentity();
        return $user;
    }

    /**
     * Accept a shift
     *
     * @param integer $id Accepting Shift id
     * @return ShiftHasDriver Newly created or existing link between a shift and a current driver
     */
    public function actionAccept($id)
    {
        $shift = $this->findModel($id);
        $driverId = $this->getDriverId();
        return $shift->addApplicant($driverId);
    }

    /**
     * Get the shifts currently delivering by the Driver
     *
     * @return array|Shift[]|ActiveDataProvider
     * @throws \yii\base\InvalidConfigException
     */
    public function actionActive()
    {
        $driverId = $this->getDriverId();
        return Shift::getActiveFor($driverId);
    }

    /**
     * Get the shifts which the current Driver already applied to
     *
     * @return array|Shift[]|ActiveDataProvider
     * @throws \yii\base\InvalidConfigException
     */
    public function actionApplied()
    {
        $driverId = $this->getDriverId();

        return Shift::getAppliedBy($driverId);
    }

    /**
     * Get the shifts available to apply to
     *
     * @return array|Shift[]|ActiveDataProvider
     * @throws \yii\base\InvalidConfigException
     */
    public function actionAvailable()
    {
        $driverId = $this->getDriverId();
        $latitude = \Yii::$app->request->get('latitude');
        $longitude = \Yii::$app->request->get('longitude');
        $stores = \Yii::$app->request->get('stores');
        $text = \Yii::$app->request->get('keyword');
        $fromDate = \Yii::$app->request->get('fromDate');

        $connectedstores = \Yii::$app->request->get('connectedstores');

        if (empty($latitude) || empty($longitude)) {
            throw new BadRequestHttpException('Latitude and longitude are required.');
        }

        $model = new Shiftsavailable();

        return $model->search(compact('driverId', 'latitude', 'longitude','stores','text','connectedstores','fromDate'));
    }

    /**
     * Get the shifts available to apply to
     *
     * @return array|Shift[]|ActiveDataProvider
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCompleted()
    {
        $driverId = $this->getDriverId();
        return Shift::getCompletedBy($driverId);
    }

    /**
     * Decline a shift
     *
     * @param integer $id Declining Shift id
     * @return bool True anyway
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionDecline($id)
    {
        $shift = $this->findModel($id);
        $driverId = $this->getDriverId();
        return ['result' => $shift->removeDriver($driverId)];
    }

    /**
     * View all shifts list
     *
     * @return array|Shift[]|ActiveDataProvider
     * @throws \yii\base\InvalidConfigException
     */
    public function actionSearch()
    {
        $searchModel = new ShiftSearch();
        $searchModel->modelClass = $this->modelClass;
        $shifts = $searchModel->search(\Yii::$app->request->getQueryParams());
        return $shifts;
    }

    /**
     * Get all shifts assigned to a current driver by Store owners
     *
     * @return array|Shift[]|ActiveDataProvider
     */
    public function actionMy()
    {
        //TODO: Alireza sort ascending
        $driverId = $this->getDriverId();
        return Shift::getAllocatedFor($driverId);
    }

    /**
     * Start the specified Shift
     *
     * @param integer $id Shift's ID
     * @return Shift
     */
    public function actionStart($id)
    {
        $shift = $this->findModel($id);
        $shift->setStateActive();
        return $shift;
    }

    /**
     * Stop the specified Shift
     *
     * @param integer $id Shift's ID
     * @return Shift
     */
    public function actionStop($id)
    {
        $shift = $this->findModel($id);
        $shift->setStateApproval(
            \Yii::$app->request->post('deliveryCount', 0),
            \Yii::$app->request->post('payment', 0)
        );
        return $shift;
    }

    /**
     * Accept request review
     *
     * @param integer $id Shift Id
     * @return Shift
     */
    public function actionAcceptRequestReview($id)
    {
        // should be post
        // $id = \Yii::$app->request->post('id', 0);
        $shift = $this->findModel($id);
        // change to latest dispute
        $reviewed = $shift->getLastShiftRequestReview($id);
        $deliverycount = $reviewed->deliveryCount;
        // TODO: include subscription table and find  subscription by store account. subscription table not yet created
        $minpayment = 60; $perdelivery=5; $dollarvalue=1;
        $payment=$deliverycount*$perdelivery*$dollarvalue;
        if($minpayment > $payment){
            $payment=$minpayment;
        }
        $shift->setStateCompleted($deliverycount, $payment);
        return $shift;
    }




}