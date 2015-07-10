<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "StoreOwner".
 *
 * @property integer $id
 * @property integer $companyId
 * @property integer $franchiserId
 *
 *
 * @property Company $company company
 * @property Store[] $stores stores
 * @property Store $storeCurrent store current
 * @property User $user user
 */
class StoreOwner extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'StoreOwner';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userId', 'companyId', 'franchiserId'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'companyId' => Yii::t('app', 'Company ID'),
            'franchiserId' => Yii::t('app', 'Franchiser ID'),
        ];
    }
    
    /**
     * Get company
     * 
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'companyId']);
    }
    
    /**
     * Get user
     * 
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }

    /**
     * Get stores
     *
     * @return \yii\db\ActiveRecord
     */
    public function getStores()
    {
        return $this->hasMany(Store::className(), ['storeOwnerId' => 'id']);
    }

    /**
     * Get stores
     *
     * @return Store
     */
    public function getStoreCurrent()
    {
        return $this->user->getStoreCurrent();
    }

    /**
     * Set current store
     *
     * @param int $storeId
     */
    public function setStoreCurrentById($storeId)
    {
        \Yii::$app->session->set('currentStoreId', $storeId);
    }

    /**
     * Get StoreOwnerFavouriteDrivers
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStoreOwnerFavouriteDrivers()
    {
        return $this->hasMany(
            StoreOwnerFavouriteDrivers::className(), ['storeOwnerId' => 'id']
        );
    }

    /**
     * Get FavouriteDrivers
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFavouriteDrivers()
    {
        return $this->hasMany(Driver::className(), ['id' => 'driverId'])
            ->via('storeOwnerFavouriteDrivers');
    }

    /**
     * Add driver to favourite
     *
     * @param integer $driverId Driver id
     */
    public function addFavouriteDriver($driverId)
    {
        $favouriteDriver = new StoreOwnerFavouriteDrivers;
        $favouriteDriver->storeOwnerId = $this->id;
        $favouriteDriver->driverId = $driverId;
        $favouriteDriver->save();
    }

    /**
     * Remove driver from favourites
     *
     * @param integer $driverId Driver id
     */
    public function removeFavouriteDriver($driverId)
    {
        $favouriteDriver = StoreOwnerFavouriteDrivers::findOne(
            [
                'storeOwnerId' => $this->id,
                'driverId' => $driverId
            ]
        );
        $favouriteDriver->delete();
    }
}
