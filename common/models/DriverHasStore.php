<?php

namespace common\models;

use Yii;
use common\models\query\DriverHasStoreQuery;
use yii\db\ActiveQuery;
use yii\web\UnauthorizedHttpException;

/**
 * @package common\models
 *
 * This is the model class for table "DriverHasStore".
 *
 * @property integer $id
 * @property integer $driverId
 * @property integer $storeId
 * @property integer $isInvitedByStoreOwner
 * @property integer $isAcceptedByDriver
 *
 * @property Driver $driver
 * @property Store $store
 */
class DriverHasStore extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'DriverHasStore';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            [
                [
                    'driverId',
                    'storeId',
                    'isInvitedByStoreOwner',
                    'isAcceptedByDriver'
                ],
                'integer'
            ]
        ];
        return array_merge(parent::rules(), $rules);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $attributeLabels = [
            'id' => Yii::t('app', 'ID'),
            'driverId' => Yii::t('app', 'Driver ID'),
            'storeId' => Yii::t('app', 'Store ID'),
            'isInvitedByStoreOwner' => Yii::t('app', 'Is Invited By Store Owner'),
            'isAcceptedByDriver' => Yii::t('app', 'Is Accepted By Driver')
        ];
        return array_merge(parent::attributeLabels(), $attributeLabels);
    }

    /**
     * Make this accepted by the Driver
     *
     * @return $this If the Invitation was accepted by its Driver
     * @throws UnauthorizedHttpException If some another Driver tries to accept the invitation
     */
    public function accept()
    {
        $driver = Driver::getCurrent();
        if (empty($driver) || $driver->primaryKey != $this->driverId) {
            throw new UnauthorizedHttpException(Yii::t('app', 'The invitation may be accepted by its Driver only'));
        }
        $this->updateAttributes([
            'isAcceptedByDriver' => 1,
        ]);
        return $this;
    }

    /**
     * Make this declined by the Driver (archived)
     *
     * @return $this If the Invitation was declined by its Driver
     * @throws UnauthorizedHttpException If some another Driver tries to accept the invitation
     */
    public function decline()
    {
        $driver = Driver::getCurrent();
        if (empty($driver) || $driver->primaryKey != $this->driverId) {
            throw new UnauthorizedHttpException(Yii::t('app', 'The invitation may be declined by its Driver only'));
        }
        $this->updateAttributes([
            'isArchived' => 1,
        ]);
        return $this;
    }

    /**
     * @inheritdoc
     * @return DriverHasStoreQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DriverHasStoreQuery(get_called_class());
    }

    /**
     * @return ActiveQuery
     */
    public function getDriver()
    {
        return $this->hasOne(
            static::getClassName('Driver'),
            [
                'id' => 'driverId',
            ]
        );
    }

    /**
     * @return ActiveQuery
     */
    public function getStore()
    {
        return $this->hasOne(
            static::getClassName('Store'),
            [
                'id' => 'storeId',
            ]
        );
    }

    public static function inviteAccepted($user_id, $store_id, $accept_status = 0){

        if(!DriverHasStore::find()->where( ['driverId' => $user_id, 'storeId' => $store_id] )->one()){
            $driver_has_store = new DriverHasStore();
            $driver_has_store->driverId = $user_id;
            $driver_has_store->storeId = $store_id;
            $driver_has_store->createdAt = time();
            $driver_has_store->updatedAt = time();
            $driver_has_store->isInvitedByStoreOwner = 1;
            $driver_has_store->isAcceptedByDriver = $accept_status;
            $driver_has_store->save();
        }

    }
}