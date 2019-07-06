<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "view_stores".
 *
 * @property integer $id
 * @property integer $companyId
 * @property integer $businessTypeId
 * @property integer $storeOwnerId
 * @property integer $paymentScheduleId
 * @property integer $imageId
 * @property string $title
 * @property string $website
 * @property string $businessHours
 * @property string $storeProfile
 * @property integer $createdAt
 * @property integer $updatedAt
 * @property integer $isArchived
 * @property string $contact_name
 * @property string $contact_phone
 * @property string $contact_email
 * @property string $block_or_unit
 * @property string $street_number
 * @property string $route
 * @property string $locality
 * @property string $administrative_area_level_1
 * @property string $postal_code
 * @property string $country
 * @property double $latitude
 * @property double $longitude
 * @property integer $geolocated
 * @property integer $timezonefk
 * @property string $googleplaceid
 * @property string $googleobj
 */
class ViewStores extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'view_stores';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'companyId', 'businessTypeId', 'storeOwnerId', 'paymentScheduleId', 'imageId', 'createdAt', 'updatedAt', 'isArchived', 'geolocated', 'timezonefk'], 'integer'],
            [['createdAt', 'updatedAt'], 'required'],
            [['latitude', 'longitude'], 'number'],
            [['title', 'website', 'businessHours', 'storeProfile'], 'string', 'max' => 255],
            [['contact_name'], 'string', 'max' => 200],
            [['contact_phone'], 'string', 'max' => 24],
            [['contact_email', 'route'], 'string', 'max' => 400],
            [['block_or_unit', 'locality', 'administrative_area_level_1'], 'string', 'max' => 250],
            [['street_number'], 'string', 'max' => 45],
            [['postal_code'], 'string', 'max' => 12],
            [['country'], 'string', 'max' => 150],
            [['googleplaceid'], 'string', 'max' => 64],
            [['googleobj'], 'string', 'max' => 4000]
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
            'businessTypeId' => Yii::t('app', 'Business Type ID'),
            'storeOwnerId' => Yii::t('app', 'Store Owner ID'),
            'paymentScheduleId' => Yii::t('app', 'Payment Schedule ID'),
            'imageId' => Yii::t('app', 'Image ID'),
            'title' => Yii::t('app', 'Title'),
            'website' => Yii::t('app', 'Website'),
            'businessHours' => Yii::t('app', 'Business Hours'),
            'storeProfile' => Yii::t('app', 'Store Profile'),
            'createdAt' => Yii::t('app', 'Created At'),
            'updatedAt' => Yii::t('app', 'Updated At'),
            'isArchived' => Yii::t('app', 'Is Archived'),
            'contact_name' => Yii::t('app', 'Contact Name'),
            'contact_phone' => Yii::t('app', 'Contact Phone'),
            'contact_email' => Yii::t('app', 'Contact Email'),
            'block_or_unit' => Yii::t('app', 'Block Or Unit'),
            'street_number' => Yii::t('app', 'Street Number'),
            'route' => Yii::t('app', 'Route'),
            'locality' => Yii::t('app', 'Locality'),
            'administrative_area_level_1' => Yii::t('app', 'Administrative Area Level 1'),
            'postal_code' => Yii::t('app', 'Postal Code'),
            'country' => Yii::t('app', 'Country'),
            'latitude' => Yii::t('app', 'Latitude'),
            'longitude' => Yii::t('app', 'Longitude'),
            'geolocated' => Yii::t('app', 'Geolocated'),
            'timezonefk' => Yii::t('app', 'Timezonefk'),
            'googleplaceid' => Yii::t('app', 'Googleplaceid'),
            'googleobj' => Yii::t('app', 'Googleobj'),
        ];
    }
}
