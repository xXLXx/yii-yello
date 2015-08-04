<?php

namespace frontend\controllers;

use common\models\Driver;
use yii\rbac\Role;
use yii\web\NotFoundHttpException;
use api\common\models\DriverHasStore;
use common\models\search\DriverSearch;

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
    public function actionAutocompleteOld()
    {
        $searchText = \Yii::$app->request->get('searchText');
        $user = \Yii::$app->user->identity;
		//TODO: Jovani, Lalit store owner central validation in basecontroller at frontend and user model.
        if(!isset($user->storeOwner->storeCurrent->id)){
            return "Please create store first.";
        }
        
        
        $storeId = $user->storeOwner->storeCurrent->id;
        $ids = DriverHasStore::find()
            ->select('driverId')
            ->andWhere(['storeId' => $storeId])
            ->column();
        $drivers = Driver::find()
            ->with(['image'])
            //->andWhere(['like', 'email', $searchText])
            ->andWhere(['or', ['like', 'username', $searchText], ['like', 'email', $searchText]])
            ->andWhere(['not in', 'User.id', $ids])
            ->all();

        if (!$drivers) {
            $valid_email = filter_var($searchText, FILTER_VALIDATE_EMAIL);
            //@todo Pass the correct messages here.
            if($valid_email === false){
                return "<div class='error_message'>Sorry there are no matches for your search. If you have an email address for the driver please enter above.</div>";
            } else {
                return "<div class='error_message'>Sorry there are no matches for your search. If you want to invite \"$searchText\" via email then press send button.</div>";
            }

        }
        return $this->renderPartial('autocomplete', [
            'drivers' => $drivers
        ]);
    }
    
    
    
    public function actionAutocomplete()
    {
        $user = \Yii::$app->user->identity;
        $params = \Yii::$app->request->post();
        $params['category']='uninvited';
        $driverSearch = new DriverSearch();
        $drivers = $driverSearch->buildQuery($params)->all();
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
