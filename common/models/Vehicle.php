<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "Vehicle".
 *
 * @property integer $id
 * @property integer $vehicleTypeId
 * @property string $registration
 * @property string $make
 * @property string $model
 * @property string $year
 * @property integer $imageId
 * @property integer $licenseNumber
 * @property integer $licensePhotoId
 * @property integer $driverId
 *
 * @property User $user user
 * @property Image $image image vehicle photo
 * @property Image $licensePhoto license photo
 * @property VehicleType $vehicleType vehicle type
 */
class Vehicle extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Vehicle';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vehicleTypeId', 'imageId', 'licensePhotoId', 'driverId'], 'integer'],
            [['registration', 'make', 'model', 'year', 'licenseNumber'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'vehicleTypeId' => Yii::t('app', 'Type ID'),
            'registration' => Yii::t('app', 'Registration'),
            'make' => Yii::t('app', 'Make'),
            'model' => Yii::t('app', 'Model'),
            'year' => Yii::t('app', 'Year'),
            'imageId' => Yii::t('app', 'Image ID'),
            'licenseNumber' => Yii::t('app', 'License Number'),
            'licensePhotoId' => Yii::t('app', 'License Photo ID'),
            'driverId' => Yii::t('app', 'Driver ID'),
        ];
    }

    /**
     * Get user
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'driverId']);
    }

    /**
     * Get image
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'imageId']);
    }

    /**
     * Get license photo
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLicensePhoto()
    {
        return $this->hasOne(Image::className(), ['id' => 'licensePhotoId']);
    }
    
    /**
     * Get vehicle type
     * 
     * @return \yii\db\ActiveQuery
     */
    public function getVehicleType()
    {
        return $this->hasOne(
            VehicleType::className(), ['id' => 'vehicleTypeId']
        );
    }
}
