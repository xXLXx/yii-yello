<?php

namespace frontend\models;
use \common\models\UserDriver;
use \common\models\Company;
use yii\base\Model;

/**
 * Work details form
 */
class WorkDetailsForm extends Model
{
    public $abn;
    public $accountNumber;
    public $availability;
    public $bankName;
    public $bsb;
    public $companyName;
    public $isAllowedToWorkInAustralia;
    public $registeredForGst;
 
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['isAllowedToWorkInAustralia', 'registeredForGst'], 'boolean'],
            [['accountNumber', 'availability', 'abn', 'bankName', 'bsb', 'companyName'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function save()
    {
        file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', var_export('saveWorkDetails' . PHP_EOL, true), FILE_APPEND);
        $user = \Yii::$app->user->identity;
        $userDriver = UserDriver::findOne(['userId' => $user->id]);
        $userDriver->setAttributes($this->getAttributes());
        file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', var_export($userDriver->toArray(), true), FILE_APPEND);
        $userDriver->save();
        $company = Company::findOneOrCreate(['userfk' =>$user->id, 'isPrimary' => 1]);
        $company->setAttributes($this->getAttributes());
        $company->ABN=$this->abn;
        $company->registeredForGST=$this->registeredForGst;
        $company->companyName=$this->companyName;
        if($this->companyName==null){
        }
        $company->save();
        $user->signup_step_completed = 3;
        $user->save();

    }
}