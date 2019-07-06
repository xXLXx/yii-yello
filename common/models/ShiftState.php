<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ShiftState".
 *
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property integer $sort
 * @property string $color color
 */
class ShiftState extends BaseModel
{
    /**
     * @inheritdoc
     */
    protected static $_namespace = __NAMESPACE__;

    const STATE_PENDING = 'pending';
    const STATE_YELLO_ALLOCATED = 'yelloAllocated';
    const STATE_ALLOCATED = 'allocated';
    const STATE_ACTIVE = 'active';
    const STATE_APPROVAL = 'approval';
    const STATE_COMPLETED = 'completed';
    const STATE_DISPUTED = 'disputed';
    const STATE_UNDER_REVIEW = 'underReview';
    const STATE_PENDING_PAYMENT = 'pendingPayment';

    // no idea why this is mapped but I'm sure we'll find out
//    private static $siteStateMapping = [
//        self::STATE_DISPUTED => self::STATE_APPROVAL,
//        self::STATE_UNDER_REVIEW => self::STATE_APPROVAL,
//        self::STATE_PENDING_PAYMENT => self::STATE_COMPLETED,
//    ];
    private static $siteStateMapping = [
        self::STATE_DISPUTED => self::STATE_DISPUTED,
        self::STATE_UNDER_REVIEW => self::STATE_UNDER_REVIEW,
        self::STATE_PENDING_PAYMENT => self::STATE_PENDING_PAYMENT,
    ];

    public $shiftCount;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ShiftState';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            [['sort'], 'integer'],
            [['name', 'title', 'color'], 'string', 'max' => 255]
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
            'name' => Yii::t('app', 'Name'),
            'title' => Yii::t('app', 'Title'),
            'sort' => Yii::t('app', 'Sort')
        ];
        return array_merge(parent::attributeLabels(), $labels);
    }

    /**
     * Get Shift's class name
     *
     * @return string|Shift
     */
    public static function shiftClass()
    {
        return Shift::className();
    }

    /**
     * Get all Shifts of this State
     *
     * @return \yii\db\ActiveQuery
     */
    public function getShifts()
    {
        return $this->hasMany(
            $this->getClassName('Shift'),
            [
                'shiftStateId' => 'id',
            ]
        );
    }

    /**
     * Get shift states with assigned drivers
     *
     * @return array
     */
    public static function getStatesForShiftList()
    {
        return [
            self::STATE_YELLO_ALLOCATED,
            self::STATE_ALLOCATED,
            self::STATE_ACTIVE,
            self::STATE_APPROVAL,
            self::STATE_COMPLETED,
            self::STATE_DISPUTED,
            self::STATE_PENDING_PAYMENT,
            self::STATE_UNDER_REVIEW,
        ];
    }

    /**
     * @param Shift $shift
     * @return ShiftState
     */
    public static function getStateForSite( Shift $shift )
    {
        $shiftState = self::findOne(['id' => $shift->shiftStateId]);

        if ( isset(self::$siteStateMapping[$shiftState->name]) ) {

            $shiftStateNameForSite = self::$siteStateMapping[$shiftState->name];
            $shiftState = self::findOne(['name' => $shiftStateNameForSite]);
        }

        return $shiftState;
    }

}
