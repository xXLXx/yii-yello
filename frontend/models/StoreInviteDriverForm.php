<?php

namespace frontend\models;

use yii\base\Model;
use common\models\DriverHasStore;
use common\helpers\EventNotificationsHelper;

/**
 * Driver has store form
 *
 * @author markov
 */
class StoreInviteDriverForm extends Model
{
    public $id;
    public $driverId;
    public $storeId;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['driverId', 'storeId', 'id'], 'integer'],
            [['driverId'], 'required'],
        ];
    }
    
    /**
     * Set data
     * 
     * @param integer $driverHasStoreId driverHasStore id
     * @throws NotFoundHttpException
     */
    public function setData($driverHasStoreId) 
    {
        if ($driverHasStoreId) {
            $driverHasStore = DriverHasStore::findOne($driverHasStoreId);
            if (!$driverHasStore) {
                throw new NotFoundHttpException('DriverHasStore not found');
            }
            $this->setAttributes($driverHasStore->getAttributes());
        } 
    }
    
    /**
     * Save
     * 
     * @return DriverHasStore
     */
    public function save() 
    {
        if (!$this->id) {
            $user = \Yii::$app->user->identity;
            $storeId = $user->storeOwner->storeCurrent->id;
            $this->storeId = $storeId;
            $driverHasStore = DriverHasStore::findOne([
                'driverId'  => $this->driverId,
                'storeId'   => $this->storeId
            ]);
            if (!$driverHasStore) {
                $driverHasStore = new DriverHasStore();
            }
        } else {
            $driverHasStore = DriverHasStore::findOne($this->id);
        }
        $driverHasStore->setAttributes($this->getAttributes());
        $driverHasStore->isInvitedByStoreOwner = true;
        
        $driverHasStore->save();

        EventNotificationsHelper::storeInvite($this->driverId, $this->storeId);

        return $driverHasStore;
    }
}
