<?php

namespace common\models;

use common\helpers\ArrayHelper;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\db\Query;
use common\models\Shift;

/**
 * This is the model class for table "shiftsavailable".
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
 * @property string $thedriverid
 * @property string $title
 * @property string $block_or_unit
 * @property string $street_number
 * @property string $route
 * @property string $locality
 * @property string $postal_code
 * @property double $latitude
 * @property double $longitude
 *
 * @property Store $store
 * @property Image $image
 */
class Shiftsavailable extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shiftsavailable';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'isVehicleProvided', 'isYelloDrivers', 'isMyDrivers', 'createdAt', 'updatedAt', 'isArchived', 'storeId', 'shiftStateId', 'deliveryCount', 'payment', 'isFavourites', 'thedriverid'], 'integer'],
            [['start', 'end', 'actualStart', 'actualEnd'], 'safe'],
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

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return ArrayHelper::merge(parent::fields(), [
            'start' =>  function ($model, $attribute) {
                    return strtotime($model->$attribute);
                },
            'end' =>  function ($model, $attribute) {
                    return strtotime($model->$attribute);
                }
        ]);
    }

    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        return [
            'image',
            'store',
        ];
    }

    /**
     * Filter shifts by driver and within a proximity.
     * But exclude those the driver had applied already.
     *
     * @param array $params
     *
     * @return \yii\data\ActiveDataProvider
     */
    public function search($params = [])
    {
        if (empty($params['driverId']) || empty($params['latitude']) || empty($params['longitude'])) {
            return false;
        }
        

        
        $query = static::find();
        //        $query->andWhere(['OR', ['thedriverid' => $params['driverId']], ['thedriverId' => '0']]);
        // only choose yello records where the driver is not a mydriver
        $query->andWhere(['OR', ['thedriverid' => $params['driverId']], 
    
        ['AND',['thedriverId' => '0'],
        ['NOT IN', 'storeId', (new Query())->select('storeId')->from('driverhasstore')->where(['isArchived' => '0', 'driverId' => $params['driverId'],'isAcceptedByDriver'=>1])],
        ['NOT IN', 'storeId', (new Query())->select('storefk')->from('storeownerfavouritedrivers')->where(['isArchived' => '0', 'driverId' => $params['driverId']])]

        ]]);
        //        $query->andWhere(['OR', ['thedriverid' => $params['driverId']], ['AND',['thedriverId' => '0'],['NOT IN', 'storeId', (new Query())->select('storeId')->from('driverhasstore')->where(['isArchived' => '0', 'driverId' => $params['driverId'],'isAcceptedByDriver'=>1])]]]);
        $query->andWhere(new Expression('ABS(latitude-'.$params['latitude'].') < 0.15'));
        $query->andWhere(new Expression('ABS(longitude-'.$params['longitude'].') < 0.15'));
        $query->andWhere(['NOT IN', 'id', (new Query())->select('shiftId')->from('shifthasdriver')->where(['isArchived' => '0', 'driverId' => $params['driverId']])]);

        $query->orderBy(['start'=>SORT_ASC]);

        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }

    /**
     * Filter shifts by driver and within a proximity.
     *
     * @param array $params
     *
     * @return \yii\data\ActiveDataProvider
     */
    public function searchyello($params = [])
    {
        if (empty($params['driverId']) || empty($params['latitude']) || empty('longitude')) {
            return false;
        }

        $query = static::find();
        $query->andWhere(['AND',['thedriverid' => 0],['isYelloDrivers'=>1]]);
        $query->andWhere(new Expression('ABS(latitude-'.$params['latitude'].') < 0.15'));
        $query->andWhere(new Expression('ABS(longitude-'.$params['longitude'].') < 0.15'));

        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }


    /**
     * Filter shifts by driver and within a proximity.
     *
     * @param array $params
     *
     * @return \yii\data\ActiveDataProvider
     */
    public function searchmine($params = [])
    {
        if (empty($params['driverId']) || empty($params['latitude']) || empty('longitude')) {
            return false;
        }

        $query = static::find();
        $query->andWhere(['thedriverid' => $params['driverId']]);
        $query->andWhere(new Expression('ABS(latitude-'.$params['latitude'].') < 0.15'));
        $query->andWhere(new Expression('ABS(longitude-'.$params['longitude'].') < 0.15'));
        $query->orderBy(['start'=>SORT_ASC]);
        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }





    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStore()
    {
        return $this->hasOne(\api\modules\v1\models\Store::className(), ['id' => 'storeId']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDriverHasStore()
    {
        return $this->hasOne(\api\modules\v1\models\Store::className(), ['id' => 'storeId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->store->getImage();
    }
    

    
}
