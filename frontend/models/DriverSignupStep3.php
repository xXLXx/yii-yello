<?php

namespace frontend\models;

use common\models\Company;
use common\models\User;
use common\models\UserDriver;
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
    public $isAvailableToWork;
    public $companyName;
    public $registeredForGST;
    public $ABN;

    public $bankName;
    public $bsb;
    public $accountNumber;
    public $agreedDriverTandC;

    
    
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'isAvailableToWork', 'bankName', 'bsb', 'accountNumber', 'agreedDriverTandC'
                ],
                'required'
            ],
            [
                'agreedDriverTandC', 'compare', 'compareValue' => true, 'message' => 'You must agree to the terms and conditions'
            ]
            ];
    }

    public function attributeLabels()
    {
        $labels = [
            'isAvailableToWork'=> \Yii::t('app', 'Allowed to work in Australia'),
            'agreedDriverTandC' =>  \Yii::t('app', 'I agree to the terms and conditions')
        ];
        return array_merge(parent::attributeLabels(), $labels);
    }

    /**
     * Set data from User/Driver
     *
     * @param \common\models\User $user
     */
    public function setData($user)
    {
        if ($user->userDriver) {
            $this->setAttributes($user->userDriver->getAttributes());
        }

        if ($user->company) {
            $this->setAttributes($user->company->getAttributes());
        }
    }

    /**
     * Save this form.
     * The transactional way shall ensure we save this record at once
     * with not a single error.
     *
     * @param User $user
     *
     * @return boolean
     */
    public function save($user)
    {
        if (!$this->validate()) {

            return false;
        }

        $transaction = \Yii::$app->db->beginTransaction();
        try {

            $userDriver = new UserDriver();

            if ($user->userDriver) {
                $userDriver = $user->userDriver;
            }
            $userDriver->setAttributes($this->getAttributes());
            if (!$userDriver->save()) {
                $error = $userDriver->getFirstError();
                $this->addError(key($error), current($error));
                throw new \yii\db\Exception(current($error));
            }

            $company = new Company();
            if ($user->company) {
                $company = $user->company;
            }
            $company->setAttributes($this->getAttributes());
            if (!$company->save()) {
                $error = $company->getFirstError();
                $this->addError(key($error), current($error));
                throw new \yii\db\Exception(current($error));
            }
                    if($user->signup_step_completed<3){
                        $user->signup_step_completed = 3;
                    }

            $user->save(false);

            $transaction->commit();

            return true;
        } catch (\Exception $e) {
            \Yii::error($e->getMessage());
            $transaction->rollBack();
        }

        return false;
    }

}