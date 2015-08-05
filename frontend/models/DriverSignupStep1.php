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
class DriverSignupStep1 extends Model
{
    // company record - all other company info is hardcoded for signup
    public $id; // storeid
    
    // company address
    public $emergencycontactname;
    public $emergencycontactphone;
    public $personalprofile;
    
    public $block_or_unit;
    public $street_number;
    public $route;
    public $locality;
    public $administrative_area_level_1;
    public $postal_code;
    public $country;
    public $formatted_address;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        //TODO:jovani all fields are required.
        return [
            [
                [
                    'id', 
                    'emergencycontactname', 'emergencycontactphone', 'personalprofile',
                    'block_or_unit', 'street_number', 'route', 'locality', 'administrative_area_level_1', 'postal_code', 'country',
                    'formatted_address'
                ],
                'safe'
            ]

            
            ];
    }

    public function attributeLabels()
    {
        $labels = [
            'street_number' => '',
            'route' => '',
            'companyname'=>'Company Name',
            'block_or_unit'=>'',
            'administrative_area_level_1'=> \Yii::t('app', 'State'),
            'postal_code'=> \Yii::t('app', 'Postcode'),
            'locality'=> \Yii::t('app', 'Suburb'),
            'emergencycontactname'=> \Yii::t('app', 'Name'),
            'emergencycontactphone'=> \Yii::t('app', 'Phone'),
            'personalprofile'=> \Yii::t('app','')
            
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