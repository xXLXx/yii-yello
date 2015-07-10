<?php

namespace common\models;

use common\behaviors\DatetimeFormatBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "ShiftStateLog".
 *
 * @property integer $id
 * @property integer $shiftId
 * @property integer $shiftStateId
 * @property integer $createdAt
 * @property string $createdAtAsDatetime
 *
 * @property Shift $shift
 * @property ShiftState $shiftState
 */
class ShiftStateLog extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     * @property string $createdAtAsDatetime
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    static::EVENT_BEFORE_INSERT => ['createdAt'],
                ],
            ],
            [
                'class' => DatetimeFormatBehavior::className(),
                DatetimeFormatBehavior::ATTRIBUTES_TIMESTAMP => [
                    'createdAt',
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ShiftStateLog';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'createdAt',
                ],
                'default',
                'value' => 0,
            ],
            [
                [
                    'shiftId',
                    'shiftStateId',
                    'createdAt'
                ],
                'integer'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'shiftId' => Yii::t('app', 'Shift ID'),
            'shiftStateId' => Yii::t('app', 'Shift State ID'),
            'createdAt' => Yii::t('app', 'Created At'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return [
            'id',
            'shiftId',
            'shiftStateId',
            'shiftStateName' => function(ShiftStateLog $model) {
                $shiftState = $model->shiftState;
                if (empty($shiftState) || empty($shiftState->name)) {
                    return null;
                }
                return $shiftState->name;
            },
            'shiftStateTitle' => function(ShiftStateLog $model) {
                $shiftState = $model->shiftState;
                if (empty($shiftState) || empty($shiftState->title)) {
                    return null;
                }
                return $shiftState->title;
            },
            'createdAt' => 'createdAtAsTimestamp',
            'createdAtAsDatetime',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShift()
    {
        return $this->hasOne(Shift::className(), ['id' => 'shiftId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShiftState()
    {
        return $this->hasOne(ShiftState::className(), ['id' => 'shiftStateId']);
    }

    /**
     * @inheritdoc
     * @return \common\models\query\ShiftStateLogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ShiftStateLogQuery(get_called_class());
    }
}