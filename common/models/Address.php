<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

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
 * @property string $googleplaceid
 * @property string $googleobj
 * @property integer $countryfk
 * @property string $latitude
 * @property string $longitude
 * @property integer $createdUTC
 * @property integer $updatedUTC
 * @property integer $geolocated
 * @property integer $isarchived
 *
 * @property CompanyAddress[] $companyAddresses
 */
class Address extends BaseModel
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
            [['countryfk', 'createdUTC', 'updatedUTC', 'geolocated', 'isarchived'], 'integer'],
            [['latitude', 'longitude'], 'number'],
            [['block_or_unit', 'locality', 'administrative_area_level_1'], 'string', 'max' => 250],
            [['street_number'], 'string', 'max' => 45],
            [['route'], 'string', 'max' => 400],
            [['postal_code'], 'string', 'max' => 12],
            [['country'], 'string', 'max' => 150],
            [['formatted_address'], 'string', 'max' => 1500],
            [['googleplaceid'], 'string', 'max' => 150],
            [['googleobj'], 'string', 'max' => 4000]
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
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['createdUTC', 'updatedUTC'],
                    self::EVENT_BEFORE_UPDATE => ['updatedUTC'],
                ],
            ]
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyAddresses()
    {
        return $this->hasMany(CompanyAddress::className(), ['addressfk' => 'idaddress']);
    }

    /**
     * Handy getter of address1.
     *
     * @todo needs confirmation from mark
     * @return string
     */
    public function getAddress1()
    {
        return $this->block_or_unit . ' ' . $this->street_number . ' ' . $this->route;
    }

    /**
     * Handy getter of address2.
     *
     * @todo needs confirmation from mark
     * @return string
     */
    public function getAddress2()
    {
        return $this->locality . ' ' . $this->country . ' ' . $this->postal_code;
    }
}
