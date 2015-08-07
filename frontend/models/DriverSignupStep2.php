<?php

namespace frontend\models;

use common\models\User;
use yii\base\Model;
use yii\web\UploadedFile;
use common\models\Image;
/**
 * Store form
 *
 */
class DriverSignupStep2 extends Model
{
    // company record - all other company info is hardcoded for signup
    public $id; // storeid
    
    // company address
    public $vehicleTypeId;
    public $registration;
    
    public $make;
    public $model;
    public $year;
    public $imageId;
    
    public $licenseNumber;
    public $licensePhotoId;

    public $vehiclePhotoFile;
    public $licensePhotoFile;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        //TODO:jovani all fields are required.
        return [
            [
                [
                    'registration', 'make', 'model', 'year','licenseNumber'
                ],
                'required'
            ],
            ['year', 'integer', 'min' => 2000],
            [
                'vehicleTypeId', 'required', 'message' => \Yii::t('app', 'Please select Vehicle Type.')
            ]
        ];
    }

    public function attributeLabels()
    {
        $labels = [
            'vehicleTypeId'=> \Yii::t('app', 'Vehicle Type'), // vehicle types from database - radio buttons
         
        ];
        return array_merge(parent::attributeLabels(), $labels);
    }    
        
    
    
    /**
     * Set data from User
     * @param int $storeId
     */
    public function setData(User $user)
    {
        $company = $this->getUserPrimaryCompany($user);
    }

    /**
     * Save
     */
    public function save($user)
    {

    }



}