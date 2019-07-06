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
class StoresView extends \common\models\BaseModel
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
            'id' => 'ID',
            'companyId' => 'Company ID',
            'businessTypeId' => 'Business Type ID',
            'storeOwnerId' => 'Store Owner ID',
            'paymentScheduleId' => 'Payment Schedule ID',
            'imageId' => 'Image ID',
            'title' => 'Title',
            'website' => 'Website',
            'businessHours' => 'Business Hours',
            'storeProfile' => 'Store Profile',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
            'isArchived' => 'Is Archived',
            'contact_name' => 'Contact Name',
            'contact_phone' => 'Contact Phone',
            'contact_email' => 'Contact Email',
            'block_or_unit' => 'Block Or Unit',
            'street_number' => 'Street Number',
            'route' => 'Route',
            'locality' => 'Locality',
            'administrative_area_level_1' => 'Administrative Area Level 1',
            'postal_code' => 'Postal Code',
            'country' => 'Country',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'geolocated' => 'Geolocated',
            'timezonefk' => 'Timezonefk',
            'googleplaceid' => 'Googleplaceid',
            'googleobj' => 'Googleobj',
        ];
    }
}
