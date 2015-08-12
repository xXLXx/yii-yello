<?php

namespace common\models;

/**
 * Driver
 *
 * @author markov
 * 
 * @property DriverHasSuburb[] $driverHasSuburbs driver has suburbs
 * @property Suburb[] $suburbs suburbs
 * 
 * @property number $approvedDeliveriesCount approved deliveries count
 * @property number $completedDeliveriesCount completed deliveries count
 * @property number $totalToPay total to pay
 * @property number $paid paid
 * @property Vehicle $vehicle Driver's Vehicle
 * @property VehicleType[] $vehicleTypes VehicleType of Driver's vehicle
 * @property Shift[] $shiftsAccepted shifts accepted
 * @property StoreOwnerFavouriteDrivers[] $storeOwnerFavouriteDrivers Store Owner Favourite Drivers
 * @property StoreOwner[] $storeOwnersFromFavourites Store owners from favourites link
 * @property DriverHasStore[] $driverHasStore Driver and stores link
 * @property Store[] $stores linked Stores
 */
class Driver extends User
{
//    /**
//     * @inheritdoc
//     */
//    public static function find()
//    {
//        $role = Role::findOne(['name' => Role::ROLE_DRIVER]);
//        return parent::find()
//            ->joinWith('userDriver')
//            ->andWhere(['roleId' => $role->id]);
//    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        $fields = parent::fields();
        $fields['extended'] = function(Driver $model) {
            return $model->userDriver;
        };
        return $fields;
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShiftHasDrivers()
    {
        return $this->hasMany(ShiftHasDriver::className(), [
            'driverId' => 'id'
        ]);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShiftHasAccepted()
    {
        return $this->getShiftHasDrivers()->andWhere([
            'acceptedByStoreOwner' => 1
        ]);
    }
    
    /**
     * Get shifts accepted
     * 
     * @return \yii\db\ActiveQuery
     */
    public function getShiftsAccepted()
    {
        return $this->hasMany(Shift::className(), ['id' => 'shiftId'])
            ->via('shiftHasAccepted');
    }
    
    /**
     * Get DriverHasSuburbs
     * 
     * @return \yii\db\ActiveQuery
     */
    public function getDriverHasSuburbs()
    {
        return $this->hasMany(
            DriverHasSuburb::className(), ['driverId' => 'id']
        );
    }
    
    /**
     * Get suburbs
     * 
     * @return \yii\db\ActiveQuery
     */
    public function getSuburbs()
    {
        return $this->hasMany(Suburb::className(), ['id' => 'suburbId'])
            ->via('driverHasSuburbs');
    }

    /**
     * Get vehicle
     * 
     * @return \yii\db\ActiveQuery
     */
    public function getVehicle() 
    {
        return $this->hasOne(Vehicle::className(), ['driverId' => 'id']);
    }

    /**
     * Get vehicleType
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVehicleTypes()
    {
        return $this->hasMany(VehicleType::className(), ['id' => 'vehicleTypeId'])
            ->via('vehicle');
    }
    
    /**
     * Get completed deliveries count
     * 
     * @return number
     */
    public function getCompletedDeliveriesCount()
    {
        $shiftState = ShiftState::findOne([
            'name' => ShiftState::STATE_COMPLETED
        ]);
        $shiftsCompleted = $this->getShiftsAccepted()
            ->andWhere(['shiftStateId' => $shiftState->id])
            ->all();
        $counts = \yii\helpers\ArrayHelper::getColumn(
            $shiftsCompleted, 'deliveryCount'
        );
        return array_sum($counts);
    }
    
    /**
     * Get approved deliveries count
     * 
     * @return number
     */
    public function getApprovedDeliveriesCount()
    {
        $shiftState = ShiftState::findOne([
            'name' => ShiftState::STATE_APPROVAL
        ]);
        $shiftsApproval = $this->getShiftsAccepted()
            ->andWhere(['shiftStateId' => $shiftState->id])
            ->all();
        $counts = \yii\helpers\ArrayHelper::getColumn(
            $shiftsApproval, 'deliveryCount'
        );
        return array_sum($counts);
    }
    
    /**
     * Get total to pay
     * 
     * @return number
     */
    public function getTotalToPay()
    {
        $shiftState = ShiftState::findOne([
            'name' => ShiftState::STATE_PENDING_PAYMENT
        ]);
        $shiftsPendingPayment = $this->getShiftsAccepted()
            ->andWhere(['shiftStateId' => $shiftState->id])
            ->all();
        $payments = \yii\helpers\ArrayHelper::getColumn(
            $shiftsPendingPayment, 'payment'
        );
        return array_sum($payments);
    }
    
    /**
     * Get paid
     * 
     * @return number
     */
    public function getPaid()
    {
        $shiftState = ShiftState::findOne([
            'name' => ShiftState::STATE_COMPLETED
        ]);
        $shiftsCompleted = $this->getShiftsAccepted()
            ->andWhere(['shiftStateId' => $shiftState->id])
            ->all();
        $payments = \yii\helpers\ArrayHelper::getColumn(
            $shiftsCompleted, 'payment'
        );
        return array_sum($payments);
    }

    /**
     * Get StoreOwnerFavouriteDrivers
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStoreOwnerFavouriteDrivers()
    {
        return $this->hasMany(
            StoreOwnerFavouriteDrivers::className(), ['driverId' => 'id']
        );
    }

    /**
     * Get FavouriteDrivers
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStoreOwnersFromFavourites()
    {
        return $this->hasMany(StoreOwner::className(), ['id' => 'storeOwnerId'])
            ->via('storeOwnerFavouriteDrivers');
    }

    /**
     * Is driver favourite for store owner
     *
     * @param integer $storeOwnerId Store Owner Id
     *
     * @return null|static
     */
    public function favouriteForStoreOwner($storeOwnerId)
    {
        $favouriteForStoreOwner = StoreOwnerFavouriteDrivers::findOne(
            [
                'driverId' => $this->id,
                'storeOwnerId' => $storeOwnerId
            ]
        );
        return $favouriteForStoreOwner;
    }

    /**
     * Is driver favourite for current Store Owner
     *
     * @return Driver|null|static
     */
    public function favouriteForCurrentStoreOwner()
    {
        $storeOwner = \Yii::$app->user->getIdentity()->storeOwner;
        return $this->favouriteForStoreOwner($storeOwner->id);
    }

    /**
     * Get DriverHasStore
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDriverHasStore()
    {
        return $this->hasMany(
            DriverHasStore::className(), ['driverId' => 'id']
        );
    }

    /**
     * Get Linked Stores
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStores()
    {
        return $this->hasMany(Store::className(), ['id' => 'storeId'])
            ->via('driverHasStore');
    }

    /**
     * Get company
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['userfk' => 'id'])
            ->where(['isPrimary' => 1]);
    }

    /**
     * Get Company Address
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyAddress()
    {
        return $this->hasOne(CompanyAddress::className(), ['companyfk' => 'id'])
            ->via('company');
    }

    /**
     * Get Address
     *
     * @return \yii\db\ActiveRecord
     */
    public function getAddress()
    {
        return $this->hasOne(Address::className(), ['idaddress' => 'addressfk'])
            ->via('companyAddress');
    }

    /**
     * Handy getter of address1.
     * @return string
     */
    public function getAddress1()
    {

        if($this->address){
            return $this->address->block_or_unit . ' ' . $this->address->street_number . ' ' . $this->address->route;
        }
    }
}