<?php

namespace api\modules\v1\controllers;
use api\modules\v1\filters\Auth;
use api\modules\v1\models\DriverHasStore;
use api\modules\v1\models\search\DriverHasStoreSearch;
use common\models\StoreOwnerFavouriteDrivers;
use yii\data\ActiveDataProvider;

/**
 * Class InvitationController
 *
 * v1-specific Restful Invitation controller
 *
 * @package api\modules\v1\controllers
 *
 * @method DriverHasStore findModel(integer $id)
 */

class InvitationController extends \api\common\controllers\InvitationController
{
    /**
     * @inheritdoc
     */
    public $modelClass = 'api\modules\v1\models\DriverHasStore';

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
     * Accept the invitation
     *
     * @param integer $id
     * @return $this
     */
    public function actionAccept($id)
    {
        $model = $this->findModel($id);

        //Remove driver from favourite as he is now accepted
        $fav = StoreOwnerFavouriteDrivers::findOne(['driverId' => $model->driverId, 'storefk' => $model->storeId]);
        if($fav){
            $fav->delete();
        }

        return $model->accept();
    }

    /**
     * Get invitations that were not accepted by the current Driver
     *
     * @return ActiveDataProvider
     */
    public function actionAvailable()
    {
        $searchModel = $this->getSearchModel();
        $searchModel->isAcceptedByDriver = false;
        $dataProvider = $searchModel->search(\Yii::$app->request->get());
        return $dataProvider;
    }

    /**
     * Get invitations accepted by the current Driver
     *
     * @return ActiveDataProvider
     */
    public function actionConnected()
    {
        $searchModel = $this->getSearchModel();
        $searchModel->isAcceptedByDriver = true;
        return $searchModel->search(\Yii::$app->request->get());
    }

    public function actionDecline($id)
    {
        $model = $this->findModel($id);
        $invitation = $model->decline();
        return [
            'result' => $invitation->isArchived
        ];
    }

    /**
     * Get all invitations made for the current Driver
     *
     * @return ActiveDataProvider
     */
    public function actionIndex()
    {
        $searchModel = $this->getSearchModel();
        $dataProvider = $searchModel->search(\Yii::$app->request->get());
        return $dataProvider;
    }

    /**
     * Get a search model with current Driver set
     *
     * @return DriverHasStoreSearch
     */
    public function getSearchModel()
    {
        $searchModel = new DriverHasStoreSearch();
        $searchModel->driverId = $this->getDriverId();
        return $searchModel;
    }
}