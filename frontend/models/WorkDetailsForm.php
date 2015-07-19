<?php

namespace frontend\models;
use common\models\UserDriver;
use common\models\DriverHasSuburb;
use common\models\Driver;
use yii\base\Model;

/**
 * Work details form
 */
class WorkDetailsForm extends Model
{
    public $availability;
    public $isAllowedToWorkInAustralia;
    public $locations;
    public $companyName;
    public $registeredForGst;
    public $abn;
    public $bankName;
    public $bsb;
    public $accountNumber;
    public $suburbs;
 
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['isAllowedToWorkInAustralia', 'registeredForGst'], 'boolean'],
            [['accountNumber', 'availability', 'locations', 'abn', 'bankName', 'bsb', 'companyName'], 'string', 'max' => 255],
            [['suburbs'], 'safe']
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
        file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', var_export($this->suburbs, true), FILE_APPEND);
        if (is_array($this->suburbs) && count($this->suburbs)) {
            foreach ($this->suburbs as $suburbId) {
                $hasSuburb = DriverHasSuburb::findOne([
                    'driverId' => $userDriver->userId,
                    'suburbId' => $suburbId,
                    'isArchived' => 0
                ]);
                if (!$hasSuburb) {
                    $driverHasSuburb = new DriverHasSuburb();
                    $driverHasSuburb->driverId = $userDriver->userId;
                    $driverHasSuburb->suburbId = $suburbId;
                    $driverHasSuburb->save();
                    file_put_contents(\Yii::$app->basePath . '/../frontend/runtime/logs/driverApiLog.txt', var_export($driverHasSuburb->toArray(), true), FILE_APPEND);
                }
            }
        }

    }
}