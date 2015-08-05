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
class DriverSignupStep3 extends Model
{
    // company record - all other company info is hardcoded for signup
    public $id; // storeid
    
    // company address
    public $isAllowedToWorkInAustralia;
    public $companyName;
    public $registeredForGST;
    public $abn;
    


    public $bankname;
    public $bsb;
    public $accountNumber;
    public $agreedDriverTandC;

    
    
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        //TODO:jovani all fields are required.
        return [
            
            ];
    }

    public function attributeLabels()
    {
        $labels = [
            'isAllowedToWorkInAustralia'=> \Yii::t('app', 'Allowed to work in Australia'), 
            'agreedDriverTandC' =>  \Yii::t('app', 'I agree to the terms and conditions')
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