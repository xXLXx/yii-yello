<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "myshiftsavailable".
 *
 * @property integer $id
 * @property string $start
 * @property string $end
 * @property integer $isVehicleProvided
 * @property integer $isYelloDrivers
 * @property integer $isMyDrivers
 * @property string $approvedApplicationId
 * @property integer $createdAt
 * @property integer $updatedAt
 * @property integer $isArchived
 * @property integer $storeId
 * @property integer $shiftStateId
 * @property string $actualStart
 * @property string $actualEnd
 * @property integer $deliveryCount
 * @property integer $payment
 * @property integer $isFavourites
 * @property integer $thedriverid
 * @property string $title
 * @property string $block_or_unit
 * @property string $street_number
 * @property string $route
 * @property string $locality
 * @property string $postal_code
 * @property double $latitude
 * @property double $longitude
 */
class Myshiftsavailable extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'myshiftsavailable';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'isVehicleProvided', 'isYelloDrivers', 'isMyDrivers', 'createdAt', 'updatedAt', 'isArchived', 'storeId', 'shiftStateId', 'deliveryCount', 'payment', 'isFavourites', 'thedriverid'], 'integer'],
            [['start', 'end', 'actualStart', 'actualEnd'], 'safe'],
            [['createdAt', 'updatedAt'], 'required'],
            [['latitude', 'longitude'], 'number'],
            [['approvedApplicationId', 'title'], 'string', 'max' => 255],
            [['block_or_unit', 'locality'], 'string', 'max' => 250],
            [['street_number'], 'string', 'max' => 45],
            [['route'], 'string', 'max' => 400],
            [['postal_code'], 'string', 'max' => 12]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'start' => Yii::t('app', 'Start'),
            'end' => Yii::t('app', 'End'),
            'isVehicleProvided' => Yii::t('app', 'Is Vehicle Provided'),
            'isYelloDrivers' => Yii::t('app', 'Is Yello Drivers'),
            'isMyDrivers' => Yii::t('app', 'Is My Drivers'),
            'approvedApplicationId' => Yii::t('app', 'Approved Application ID'),
            'createdAt' => Yii::t('app', 'Created At'),
            'updatedAt' => Yii::t('app', 'Updated At'),
            'isArchived' => Yii::t('app', 'Is Archived'),
            'storeId' => Yii::t('app', 'Store ID'),
            'shiftStateId' => Yii::t('app', 'Shift State ID'),
            'actualStart' => Yii::t('app', 'Actual Start'),
            'actualEnd' => Yii::t('app', 'Actual End'),
            'deliveryCount' => Yii::t('app', 'Delivery Count'),
            'payment' => Yii::t('app', 'Payment'),
            'isFavourites' => Yii::t('app', 'Is Favourites'),
            'thedriverid' => Yii::t('app', 'Thedriverid'),
            'title' => Yii::t('app', 'Title'),
            'block_or_unit' => Yii::t('app', 'Block Or Unit'),
            'street_number' => Yii::t('app', 'Street Number'),
            'route' => Yii::t('app', 'Route'),
            'locality' => Yii::t('app', 'Locality'),
            'postal_code' => Yii::t('app', 'Postal Code'),
            'latitude' => Yii::t('app', 'Latitude'),
            'longitude' => Yii::t('app', 'Longitude'),
        ];
    }
}
