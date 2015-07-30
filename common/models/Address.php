<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "address".
 *
 * @property integer $idaddress
 * @property string $block_or_unit
 * @property string $street_number
 * @property string $route
 * @property string $locality
 * @property string $administrative_area_level_1
 * @property string $postal_code
 * @property string $country
 * @property string $formatted_address
 * @property integer $countryfk
 * @property string $latitude
 * @property string $longitude
 * @property integer $createdUTC
 * @property integer $updatedUTC
 * @property integer $geolocated
 * @property integer $isarchived
 * @property integer $timezonefk
 *
 * @property Companyaddress[] $companyaddresses
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['countryfk', 'createdUTC', 'updatedUTC', 'geolocated', 'isarchived', 'timezonefk'], 'integer'],
            [['latitude', 'longitude'], 'number'],
            [['block_or_unit', 'locality', 'administrative_area_level_1'], 'string', 'max' => 250],
            [['street_number'], 'string', 'max' => 45],
            [['route'], 'string', 'max' => 400],
            [['postal_code'], 'string', 'max' => 12],
            [['country'], 'string', 'max' => 150],
            [['formatted_address'], 'string', 'max' => 1500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idaddress' => Yii::t('app', 'Idaddress'),
            'block_or_unit' => Yii::t('app', 'Block Or Unit'),
            'street_number' => Yii::t('app', 'Street Number'),
            'route' => Yii::t('app', 'Route'),
            'locality' => Yii::t('app', 'Locality'),
            'administrative_area_level_1' => Yii::t('app', 'Administrative Area Level 1'),
            'postal_code' => Yii::t('app', 'Postal Code'),
            'country' => Yii::t('app', 'Country'),
            'formatted_address' => Yii::t('app', 'Formatted Address'),
            'countryfk' => Yii::t('app', 'Countryfk'),
            'latitude' => Yii::t('app', 'Latitude'),
            'longitude' => Yii::t('app', 'Longitude'),
            'createdUTC' => Yii::t('app', 'Created Utc'),
            'updatedUTC' => Yii::t('app', 'Updated Utc'),
            'geolocated' => Yii::t('app', 'Geolocated'),
            'isarchived' => Yii::t('app', 'Isarchived'),
            'timezonefk' => Yii::t('app', 'Timezonefk'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyaddresses()
    {
        return $this->hasMany(Companyaddress::className(), ['addressfk' => 'idaddress']);
    }
}
