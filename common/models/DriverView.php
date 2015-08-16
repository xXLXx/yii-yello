<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "driver_view".
 *
 * @property integer $id
 * @property string $username
 * @property string $accessToken
 * @property string $authKey
 * @property string $passwordHash
 * @property string $passwordResetToken
 * @property string $email
 * @property integer $createdAt
 * @property integer $updatedAt
 * @property integer $active
 * @property integer $roleId
 * @property string $lastName
 * @property string $firstName
 * @property integer $imageId
 * @property integer $hasExtendedRights
 * @property integer $isArchived
 * @property integer $isBlocked
 * @property integer $parentId
 * @property integer $billingCompanyId
 * @property integer $signup_step_completed
 * @property integer $registeredForGST
 * @property string $companyName
 * @property string $ABN
 * @property string $contact_phone
 * @property integer $idaddress
 * @property string $street_number
 * @property string $route
 * @property string $locality
 * @property string $administrative_area_level_1
 * @property string $postal_code
 * @property string $country
 * @property string $formatted_address
 * @property double $latitude
 * @property double $longitude
 * @property string $googleplaceid
 * @property string $googleobj
 */
class DriverView extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'driver_view';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'createdAt', 'updatedAt', 'active', 'roleId', 'imageId', 'hasExtendedRights', 'isArchived', 'isBlocked', 'parentId', 'billingCompanyId', 'signup_step_completed', 'registeredForGST', 'idaddress'], 'integer'],
            [['username', 'accessToken', 'authKey', 'passwordHash', 'email', 'createdAt', 'updatedAt'], 'required'],
            [['latitude', 'longitude'], 'number'],
            [['username', 'accessToken', 'passwordHash', 'passwordResetToken', 'email', 'lastName', 'firstName', 'companyName', 'ABN'], 'string', 'max' => 255],
            [['authKey'], 'string', 'max' => 32],
            [['contact_phone'], 'string', 'max' => 24],
            [['street_number'], 'string', 'max' => 45],
            [['route'], 'string', 'max' => 400],
            [['locality', 'administrative_area_level_1'], 'string', 'max' => 250],
            [['postal_code'], 'string', 'max' => 12],
            [['country'], 'string', 'max' => 150],
            [['formatted_address'], 'string', 'max' => 1500],
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
            'username' => Yii::t('app', 'Username'),
            'accessToken' => Yii::t('app', 'Access Token'),
            'authKey' => Yii::t('app', 'Auth Key'),
            'passwordHash' => Yii::t('app', 'Password Hash'),
            'passwordResetToken' => Yii::t('app', 'Password Reset Token'),
            'email' => Yii::t('app', 'Email'),
            'createdAt' => Yii::t('app', 'Created At'),
            'updatedAt' => Yii::t('app', 'Updated At'),
            'active' => Yii::t('app', 'Active'),
            'roleId' => Yii::t('app', 'Role ID'),
            'lastName' => Yii::t('app', 'Last Name'),
            'firstName' => Yii::t('app', 'First Name'),
            'imageId' => Yii::t('app', 'Image ID'),
            'hasExtendedRights' => Yii::t('app', 'Has Extended Rights'),
            'isArchived' => Yii::t('app', 'Is Archived'),
            'isBlocked' => Yii::t('app', 'Is Blocked'),
            'parentId' => Yii::t('app', 'Parent ID'),
            'billingCompanyId' => Yii::t('app', 'Billing Company ID'),
            'signup_step_completed' => Yii::t('app', 'Signup Step Completed'),
            'registeredForGST' => Yii::t('app', 'Registered For Gst'),
            'companyName' => Yii::t('app', 'Company Name'),
            'ABN' => Yii::t('app', 'Abn'),
            'contact_phone' => Yii::t('app', 'Contact Phone'),
            'idaddress' => Yii::t('app', 'Idaddress'),
            'street_number' => Yii::t('app', 'Street Number'),
            'route' => Yii::t('app', 'Route'),
            'locality' => Yii::t('app', 'Locality'),
            'administrative_area_level_1' => Yii::t('app', 'Administrative Area Level 1'),
            'postal_code' => Yii::t('app', 'Postal Code'),
            'country' => Yii::t('app', 'Country'),
            'formatted_address' => Yii::t('app', 'Formatted Address'),
            'latitude' => Yii::t('app', 'Latitude'),
            'longitude' => Yii::t('app', 'Longitude'),
            'googleplaceid' => Yii::t('app', 'Googleplaceid'),
            'googleobj' => Yii::t('app', 'Googleobj'),
        ];
    }
}
