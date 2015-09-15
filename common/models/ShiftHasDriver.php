<?php

namespace common\models;

use common\behaviors\DatetimeFormatBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use common\helpers\EventNotificationsHelper;

/**
 * This is the model class for table "ShiftHasDriver".
 *
 * @property integer $shiftId
 * @property integer $driverId
 * @property integer $createdAt
 * @property string $createdAtAsDatetime
 * @property integer $updatedAt
 * @property string $updatedAtAsDatetime
 * @property integer $isArchived
 * @property boolean $acceptedByStoreOwner
 * @property boolean $isDeclinedByStoreOwner
 *
 */
class ShiftHasDriver extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    static::EVENT_BEFORE_INSERT => ['createdAt'],
                    static::EVENT_BEFORE_UPDATE => ['updatedAt'],
                ],
            ],
            [
                'class' => DatetimeFormatBehavior::className(),
                DatetimeFormatBehavior::ATTRIBUTES_TIMESTAMP => [
                    'createdAt',
                    'updatedAt',
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ShiftHasDriver';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            [['shiftId', 'driverId'], 'integer'],
            [
                [
                    'acceptedByStoreOwner',
                    'isDeclinedByStoreOwner',
                ],
                'boolean'
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
            'shiftId' => Yii::t('app', 'Shift ID'),
            'driverId' => Yii::t('app', 'Driver ID')
        ];
        return array_merge(parent::attributeLabels(), $labels);
    }
    
    /**
     * Decline by StoreOwner
     */
    public function declineByStoreOwner()
    {
        $this->isDeclinedByStoreOwner = true;
        $this->save();

        EventNotificationsHelper::declineShift($this->driverId, $this->shiftId);
    }
    
    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes) 
    {
        if (isset($changedAttributes['acceptedByStoreOwner'])) {
            if ($this->acceptedByStoreOwner) {
                \Yii::$app->activity->create([
                    'userId' => \Yii::$app->user->id,
                    'name' => 'ShfitAcceptedByStoreOwner',
                    'params' => [
                        'driverId' => $this->driverId,
                        'shiftId'  => $this->shiftId
                    ]
                ]);
            }
        }
        return parent::afterSave($insert, $changedAttributes);
    }

    public function getShift(){

            return $this->hasOne(Shift::className(), ['id' => 'shiftId']);

    }
}