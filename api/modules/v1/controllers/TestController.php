<?php
/**
 * v1-specific restful Shift controller
 */

namespace api\modules\v1\controllers;

use api\modules\v1\filters\Auth;
use api\modules\v1\models\Shift;
use common\models\search\ShiftSearch;
use common\models\search\ShiftStateSearch;
use common\models\ShiftHasDriver;
use common\models\ShiftState;
use common\models\Shiftsavailable;
use common\models\Yelloshiftsavailable;
use common\models\Myshiftsavailable;
use common\models\DriverHasStore;
use common\models\StoreOwnerFavouriteDrivers;
use yii\data\ActiveDataProvider;

/**
 * Class ShiftController
 * @package api\modules\v1\controllers
 *
 * @method Shift findModel(string $id)
 */

class TestController extends \api\common\controllers\ShiftController
{
    /**
     * @inheritdoc
     */
    public $modelClass = 'api\modules\v1\models\Shift';
    
    public function actionFoo()
    {
        $driverId = 176;
        $latitude = -33.7682869;
        $longitude = 151.2599374;

        // get the driver exclusions
        $fav = StoreOwnerFavouriteDrivers::find(['driverId'=>$driverId])->asArray();
        $my = DriverHasStore::find(['AND',['driverId'=>$driverId],['isAcceptedByDriver'=>1]])->asArray();
        

        $model = new Shiftsavailable();
        $myavailable =  $model->search(compact('driverId', 'latitude', 'longitude'));
        
        
        
        
        return $myavailable;
    }    
    
    

    
    
}