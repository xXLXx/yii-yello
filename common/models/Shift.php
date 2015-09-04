<?php

namespace common\models;

use common\behaviors\DatetimeFormatBehavior;
use common\behaviors\shift\ShiftStateBehavior;
use common\components\Formatter;
use Yii;
use common\models\search\ShiftSearch;
use yii\data\ActiveDataProvider;
use common\helpers\ArrayHelper;

/**
 * This is the model class for table "Shift".
 * Class Shift
 * @package \common\models
 *
 * @method processShiftState()
 * @method setStateAllocated(integer $driverId) Allocated
 * @method setStateYelloAllocated(integer $driverId) Yello allocated
 * @method setStatePending() Pending
 * @method setStateActive() Active
 * @method setStateApproval() Approval
 * @method setStateDisputed() Disputed
 * @method setStatePendingPayment() Pending Payment
 * @method setStateUnderReview() Under review
 * @method setStateCompleted(integer $deliveryCount, integer $payment) Completed
 * @method setStateByName(string $shiftStateName) Set shiftStateByName
 *
 * @property integer $id
 * @property string $start
 * @property string $startAsDatetime
 * @property string $end
 * @property integer $isVehicleProvided
 * @property boolean $isYelloDrivers
 * @property boolean $isMyDrivers
 * @property boolean $isFavourites
 * @property string $approvedApplicationId
 * @property integer $storeId
 * @property integer $shiftStateId
 * @property string $shiftStateName
 * @property string $actualStart
 * @property string $actualEnd
 * @property integer $deliveryCount
 * @property integer $payment
 *
 * @property ShiftHasDriver[] $shiftHasDrivers shiftHasDrivers
 * @property ShiftHasDriver[] $shiftHasApplicants shiftHasApplicants
 * @property Driver[] $drivers drivers
 * @property Store $store The store linked to a shift
 * @property ShiftState $shiftState shift state
 * @property ShiftStateLog[] $shiftStateLogs Shift state log rows
 * @property Driver[] $applicants driver applicants
 * @property Driver $driverAccepted driver accepted
 * @property string $visibleGroupNames visible group names
 * @property ShiftRequestReview[] $shiftRequestReview shift request review
 * @property ShiftRequestReview[] $shiftRequestReviewDesc shift request review desc created at
 * @property ShiftRequestReview $lastUserShiftRequestReview last shift request review of the current user
 * @property ShiftRequestReview $lastDriverShiftRequestReview last shift request review of the current user
 * @property ShiftCopyLog $shiftCopyLog
 */
class Shift extends BaseModel
{
    /**
     * @inheritdoc
     */
    protected static $_namespace = __NAMESPACE__;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Shift';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = [
            'ShiftStateBehavior' => ShiftStateBehavior::className(),
            [
                'class' => DatetimeFormatBehavior::className(),
                DatetimeFormatBehavior::ATTRIBUTES_STRING => [
                    'start',
                    'end',
                    'actualStart',
                    'actualEnd',
                ],
                DatetimeFormatBehavior::ATTRIBUTES_TIMESTAMP => [
                    'createdAt',
                    'updatedAt',
                ],
            ]
        ];
        return array_merge(parent::behaviors(), $behaviors);
    }

    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        return [
            'store',
            'shiftState',
            'shiftStateLogs',
            'isAppliedByMe',
            'isAcceptedByStoreOwner',
            'isDeclinedByStoreOwner',
            'startsAfterNow',
            'shiftRequestReview'
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return [
            'id',
            'start' => 'startAsTimestamp',
            'startAsDatetime',
            'end' => 'endAsTimestamp',
            'endAsDatetime',
            'isVehicleProvided',
            'isYelloDrivers',
            'isMyDrivers',
            'createdAt' => 'createdAtAsTimestamp',
            'createdAtAsDatetime',
            'updatedAt' => 'updatedAtAsTimestamp',
            'updatedAtAsDatetime',
            'storeId',
            'shiftStateId',
            'actualStart' => 'actualStartAsTimestamp',
            'actualStartAsDatetime',
            'actualEnd' => 'actualEndAsTimestamp',
            'actualEndAsDatetime',
            'deliveryCount',
            'payment',
            'isFavourites',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            [
                [
                    'isVehicleProvided', 'storeId', 'shiftStateId',
                    'deliveryCount', 'payment',
                ],
                'integer'
            ],
            [
                ['isYelloDrivers', 'isMyDrivers', 'isFavourites'], 'boolean'
            ],
            [
                [
                    'shiftStateId',
                ],
                'default',
                'value' => function(Shift $model, $attribute) {
                    if ($model->isNewRecord && $attribute == 'shiftStateId') {
                        $shiftState = ShiftState::findOne(['name' => ShiftState::STATE_PENDING,]);
                        if ($shiftState instanceof ShiftState) {
                            return $shiftState->id;
                        }
                    }
                    return null;
                },
            ],
            [
                [
                    'start', 'end', 'actualStart', 'actualEnd',
                    'approvedApplicationId'
                ],
                'string',
                'max' => 255
            ]
        ];
        return array_merge(parent::rules(), $rules);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = [
            'id' => Yii::t('app', 'ID'),
            'start' => Yii::t('app', 'Start'),
            'end' => Yii::t('app', 'End'),
            'isVehicleProvided' => Yii::t('app', 'Is Vehicle Provided'),
            'isYelloDrivers' => Yii::t('app', 'Is Yello Drivers'),
            'isMyDrivers' => Yii::t('app', 'Is My Drivers'),
            'approvedApplicationId' => Yii::t('app', 'Approved Application ID'),
        ];
        return array_merge(parent::attributeLabels(), $labels);
    }

    /**
     * @inheritdoc
     *
     * @return ShiftQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ShiftQuery(get_called_class());
    }

    /**
     * Add applicant
     * 
     * @param integer $driverId driver id
     * @return ShiftHasDriver
     */
    public function addApplicant($driverId)
    {
        $params = [
            'driverId' => $driverId,
            'shiftId' => $this->id,
        ];
        $shiftHasDriver = ShiftHasDriver::find()
            ->andWhere($params)
            ->one();
        if (!$shiftHasDriver) {
            \Yii::$app->activity->create([
                'userId' => \Yii::$app->user->id,
                'name'   => 'ShiftAddApplicant',
                'params' => $params,
            ]);
            $shiftHasDriver = new ShiftHasDriver();
            $shiftHasDriver->setAttributes($params);
            $shiftHasDriver->save();
        }
        return $shiftHasDriver;
    }
    
    /**
     * add driver
     *
     * @param integer $driverId driver id
     * @return ShiftHasDriver
     */
    public function addDriver($driverId)
    {
        $existingLink = ShiftHasDriver::find()
            ->andWhere([
                'driverId' => $driverId,
                'shiftId' => $this->id,
            ])
            ->one();
        if (!empty($existingLink) && $existingLink instanceof ShiftHasDriver) {
            return $existingLink;
        }
        $this->removeDrivers();
        $shiftHasDriver = new ShiftHasDriver();
        $shiftHasDriver->driverId = $driverId;
        $shiftHasDriver->shiftId = $this->id;
        $shiftHasDriver->save();
        return $shiftHasDriver;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShiftHasDrivers()
    {
        return $this->hasMany(ShiftHasDriver::className(), ['shiftId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDrivers()
    {
        return $this->hasMany(Driver::className(), ['id' => 'driverId'])
            ->via('shiftHasDrivers');
    }

    /**
     * Remove a driver from the current shift
     *
     * @param integer $driverId ID of the driver to remove
     * @return bool True anyway
     */
    public function removeDriver($driverId)
    {
        $this->shiftStateId=1;
        $this->save();
        
        ShiftHasDriver::deleteAll([
            'driverId' => $driverId,
            'shiftId' => $this->id,
        ]);
        return true;
    }

    /**
     * Remove drivers from the current shift
     *
     * @param integer $driverId ID of the driver to remove
     * @return bool True anyway
     */
    public function removeDrivers()
    {
        ShiftHasDriver::deleteAll([
            'shiftId' => $this->id,
        ]);
        return true;
    }

    /**
     * Get Shift's store
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStore()
    {
        $store = $this->getClassName('Store');
        return $this
            ->hasOne(
                $store,
                [
                    'id' => 'storeId',
                ]
            );
    }

    /**
     * Get shift state
     *
     * @return \yii\db\ActiveQuery
     */
    public function getShiftState()
    {
        if ( $this instanceof \api\modules\v1\models\Shift ) {
            return $this->hasOne($this->getClassName('ShiftState'), ['id' => 'shiftStateId']);
        } else {

            $shiftState = ShiftState::getStateForSite($this);
            return $shiftState;
        }
    }

    /**
     * Get shift state log rows
     *
     * @return \yii\db\ActiveQuery
     */
    public function getShiftStateLogs()
    {
        return $this
            ->hasMany($this->getClassName('ShiftStateLog'), ['shiftId' => 'id'])
            ->orderBy('createdAt');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShiftHasApplicants()
    {
        return $this->getShiftHasDrivers()->andWhere([
            'acceptedByStoreOwner'   => 0,
            'isDeclinedByStoreOwner' => 0
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShiftHasAccepted()
    {
        return $this->getShiftHasDrivers()->andWhere([
            'acceptedByStoreOwner' => 1
        ]);
    }

    /**
     * Get applicants
     *
     * @return \yii\db\ActiveQuery
     */
    public function getApplicants()
    {
        return $this->hasMany(Driver::className(), ['id' => 'driverId'])
            ->via('shiftHasApplicants');
    }

    /**
     * Get driver accepted
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDriverAccepted()
    {
        return $this
            ->hasOne(Driver::className(), ['id' => 'driverId'])
            ->via('shiftHasAccepted');
    }

    /**
     * ShiftCopyLog
     *
     * @return \yii\db\ActiveQuery
     */
    public function getShiftCopyLog()
    {
        return $this->hasOne(ShiftCopyLog::className(), ['shiftCopyId' => 'id']);
    }

    public static function getActiveFor($driverId)
    {
        $shiftState = ShiftState::findOne(['name' => ShiftState::STATE_ACTIVE]);
        $searchModel = new ShiftSearch();
        $searchModel->driverId = $driverId;
        $searchModel->modelClass = static::className();
        $searchModel->shiftStateId = $shiftState->id;
        $searchModel->appliedByDriver = true;
        $searchModel->acceptedByStoreOwner = true;
        $searchModel->declinedByStoreOwner = false;
        $dataProvider = $searchModel->search(\Yii::$app->request->getQueryParams());
        return $dataProvider;
    }

    /**
     * Get Shifts allocated to the Driver
     *
     * (for the Driver, there are 'My' shifts)
     *
     * @param int $driverId ID of the Driver
     *
     * @return array|Shift[]|ActiveDataProvider
     * @throws \yii\base\InvalidConfigException
     */
    public static function getAllocatedFor($driverId)
    {
        $shiftStateIds = ShiftState::find()
            ->where([
                'in',
                'name',
                [
                    ShiftState::STATE_ALLOCATED,
                    ShiftState::STATE_YELLO_ALLOCATED,
                    ShiftState::STATE_ACTIVE,
                ]
            ])
            ->select('id')
            ->column();

        $searchModel = new ShiftSearch();
        $searchModel->driverId = $driverId;
        $searchModel->acceptedByStoreOwner = true;
        $searchModel->modelClass = static::className();
        $searchModel->shiftStateId = $shiftStateIds;
        $searchModel->declinedByStoreOwner = false;
//        $searchModel->orderBy(['start'=>SORT_ASC]);
        $dataProvider = $searchModel->search(\Yii::$app->request->getQueryParams());
        return $dataProvider;
    }

    /**
     * Get Shifts applied by the Driver
     *
     * @param int $driverId ID of the Driver
     *
     * @return array|Shift[]|ActiveDataProvider
     * @throws \yii\base\InvalidConfigException
     */
    public static function getAppliedBy($driverId)
    {
        $shiftState = ShiftState::findOne(['name' => ShiftState::STATE_PENDING]);
        $searchModel = new ShiftSearch();
        $searchModel->driverId = $driverId;
        $searchModel->startsAfterNow = true;
        $searchModel->modelClass = static::className();
        $searchModel->shiftStateId = $shiftState->id;
        $searchModel->appliedByDriver = true;
        $searchModel->declinedByStoreOwner = false;
        $dataProvider = $searchModel->search(\Yii::$app->request->getQueryParams());
        return $dataProvider;
    }

    /**
     * Get Shifts available to apply by the Driver
     *
     * @param int $driverId ID of the Driver
     *
     * @return array|Shift[]|ActiveDataProvider
     * @throws \yii\base\InvalidConfigException
     */
    public static function getAvailableToApplyBy($driverId)
    {
        $shiftState = ShiftState::findOne(['name' => ShiftState::STATE_PENDING]);
        if (empty($shiftState)) {
            return [];
        }
            $date = new \DateTime();
        $startDate = $date->format('Y-m-d H:i:s');
        
        
        $searchModel = new ShiftSearch();
        $searchModel->modelClass = static::className();
        $searchModel->shiftStateId = $shiftState->id;
        $searchModel->startsAfterNow = true;
        $searchModel->driverId = $driverId;
        $searchModel->appliedByDriver = false;
        $searchModel->declinedByStoreOwner = false;
        $dataProvider = $searchModel->search(\Yii::$app->request->getQueryParams());
        return $dataProvider;
    }

    /**
     * Get shifts completed by the Driver
     *
     * @param int $driverId Id of the Driver
     * @return array|Shift[]|ActiveDataProvider
     */
    public static function getCompletedBy($driverId)
    {
        $shiftStateIds = ShiftState::find()
            ->where([
                'in',
                'name',
                [
                    ShiftState::STATE_APPROVAL,
                    ShiftState::STATE_DISPUTED,
                    ShiftState::STATE_COMPLETED,
                    ShiftState::STATE_PENDING_PAYMENT,
                    ShiftState::STATE_UNDER_REVIEW,
                ]
            ])
            ->select('id')
            ->column();

        $searchModel = new ShiftSearch();
        $searchModel->driverId = $driverId;
        $searchModel->acceptedByStoreOwner = true;
        $searchModel->modelClass = static::className();
        $searchModel->shiftStateId = $shiftStateIds;
        $dataProvider = $searchModel->search(\Yii::$app->request->getQueryParams());
        return $dataProvider;
    }

    /**
     * Get visible group names
     *
     * @return string
     */
    public function getVisibleGroupNames()
    {
        static $groups = [
            'isYelloDrivers'    => 'Yello',
            'isFavourites'      => 'Favourites',
            'isMyDrivers'       => 'My Drivers'
        ];
        $result = [];
        foreach ($groups as $field => $title) {
            if ($this->$field) {
                $result[$title] = \Yii::t('app', $title);
            }
        }
        return implode(', ', $result);
    }

    /**
     * Unassign driver
     *
     * @param integer $driverId
     */
    public function unassignDriver($driverId)
    {
        $this->removeDriver($driverId);
        $this->setStatePending();
    }

    /**
     * Driver decline
     *
     * @param integer $driverId
     */
    public function driverDecline($driverId)
    {
        $shiftHasDriver = $this->getShiftHasDrivers()
            ->andWhere(['driverId' => $driverId])
            ->one();
        if (!$shiftHasDriver) {
            return false;
        }
        $shiftHasDriver->declineByStoreOwner();
    }

    /**
     * Editable?
     *
     * @return boolean
     */
    public function isEditable()
    {
        static $shiftStateNamesDisabled = [
            ShiftState::STATE_APPROVAL,
            ShiftState::STATE_COMPLETED,
            ShiftState::STATE_ACTIVE
        ];
        $shiftStates = ShiftState::findAll(['name' => $shiftStateNamesDisabled]);
        $shiftStateIds = ArrayHelper::getColumn($shiftStates, 'id');
        $is=!in_array($this->shiftStateId, $shiftStateIds);
        if($is&&$this->actualStart.''==''){
            return true;
        }
        return false;
    }
    
    public function getIsEditable(){
        static $shiftStateNamesDisabled = [
            ShiftState::STATE_APPROVAL,
            ShiftState::STATE_COMPLETED,
            ShiftState::STATE_ACTIVE
        ];
        $shiftStates = ShiftState::findAll(['name' => $shiftStateNamesDisabled]);
        $shiftStateIds = ArrayHelper::getColumn($shiftStates, 'id');
        $is=!in_array($this->shiftStateId, $shiftStateIds);
        if($is&&empty($this->actualStart)&&strtotime($this->start) > time()){
            return true;
        }
        return false;        
    }
    

    /**
     * Check if we can delete this shift.
     * Should be when `start` is future and `actualSart` is null.
     */
    public function getIsDeletable()
    {
        $is=false;
//        $is = (strtotime($this->start) > time() && empty($this->actualStart));
        // a store owner should be able to delete allocated or pending shifts that have expired
        $is = (empty($this->actualStart));
        return $is;
    }

    public function init()
    {
        $this->on(static::EVENT_BEFORE_UPDATE, [$this, 'processShiftState']);
        $this->on(static::EVENT_BEFORE_INSERT, [$this, 'processShiftState']);
    }

    /**
     * Get ShiftRequestReview
     *
     * @return \yii\db\ActiveQuery[]
     */
    public function getShiftRequestReview()
    {
        return $this->hasMany(ShiftRequestReview::className(), ['shiftId' => 'id']);
    }

    /**
     * Get ShiftRequestReview created at desc
     *
     * @return \yii\db\ActiveQuery[]
     */
    public function getShiftRequestReviewDesc()
    {
        return $this->getShiftRequestReview()
            ->orderBy('createdAt DESC');
    }

    /**
     * @return ShiftRequestReview|null
     */
    public function getLastShiftRequestReview($id)
    {
        return $this->getShiftRequestReview()
            ->where(['shiftId' => $id])
            ->orderBy('createdAt DESC')
            ->limit(1)
            ->one();
    }    
    

    /**
     * @return ShiftRequestReview|null
     */
    public function getLastShiftDeliveryCount($id)
    {
        $last =  $this->getShiftRequestReview()
            ->where(['shiftId' => $id])
            ->orderBy('createdAt DESC')
            ->limit(1)
            ->one();
    }    
    

    /**
     * @return ShiftRequestReview|null
     */
    public function getLastUserShiftRequestReview()
    {
        $userId = Yii::$app->user->identity->id;

        return $this->getShiftRequestReview()
            ->where(['userId' => $userId])
            ->orderBy('createdAt DESC')
            ->limit(1)
            ->one();
    }

    
    /**
     * @return ShiftRequestReview|null
     */
    public function getLastDriverShiftRequestReview()
    {
        $userId = Yii::$app->user->identity->id;

        return $this->getShiftRequestReview()
            ->where(['shiftId'=>$this->id])
            ->andWhere(['NOT',['userId' =>  $userId]])
            ->orderBy('createdAt DESC')
            ->limit(1)
            ->one();
    }
        
    
    
    /**
     * Create activity deliveryCount
     */
    protected function createActivityDeliveryCount()
    {
        if ($this->deliveryCount) {
            \Yii::$app->activity->create([
                'userId' => \Yii::$app->user->id,
                'name' => 'ShiftDeliveryCount',
                'params' => [
                    'shiftId'       => $this->id,
                    'deliveryCount' => $this->deliveryCount
                ]
            ]);
        }
    }
    
    /**
     * Create activity payment
     */
    protected function createActivityPayment()
    {
        if ($this->payment) {
            \Yii::$app->activity->create([
                'userId' => \Yii::$app->user->id,
                'name' => 'ShiftPayment',
                'params' => [
                    'shiftId'   => $this->id,
                    'payment'   => $this->payment
                ]
            ]);
        }
    }
    
    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes) 
    {
        if (isset($changedAttributes['deliveryCount'])) {
            $this->createActivityDeliveryCount();
        }
        if (isset($changedAttributes['payment'])) {
            $this->createActivityPayment();
        }
        return parent::afterSave($insert, $changedAttributes);
    }
    

}
