<?php

namespace frontend\controllers;

use common\models\Driver;
use yii\web\NotFoundHttpException;
use api\common\models\DriverHasStore;

/**
 * Driver search controller
 *
 * @author markov
 */
class StoreInviteDriverSearchAutocompleteController extends BaseController 
{
    /**
     * Autocomplete
     */
    public function actionAutocomplete()
    {
        $searchText = \Yii::$app->request->post('searchText');
        $user = \Yii::$app->user->identity;
        $storeId = $user->storeOwner->storeCurrent->id;
        $ids = DriverHasStore::find()
            ->select('driverId')
            ->andWhere(['storeId' => $storeId])
            ->column();
        $drivers = Driver::find()
            ->with(['image'])
            ->andWhere(['like', 'username', $searchText])
            ->andWhere(['not in', 'User.id', $ids])
            ->all();
        if (!$drivers) {
            return false;
        }
        return $this->renderPartial('autocomplete', [
            'drivers' => $drivers
        ]);
    }
    
    /**
     * Get selected driver results
     * 
     * @throws NotFoundHttpException
     */
    public function actionSelected()
    {
        $this->layout = 'empty';
        $driverId = \Yii::$app->request->post('driverId');
        return $this->render('selected', [
            'driverId' => $driverId
        ]);
    }
}
