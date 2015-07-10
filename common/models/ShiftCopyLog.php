<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ShiftCopyLog".
 *
 * @property integer $id
 * @property integer $shiftId
 * @property integer $shiftCopyId
 * @property string $hash
 *
 * @property Shift $shift
 */
class ShiftCopyLog extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ShiftCopyLog';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            [['shiftId', 'shiftCopyId'], 'integer'],
            [['hash'], 'string', 'max' => 255]
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
            'shiftId' => Yii::t('app', 'Shift ID'),
            'shiftCopyId' => Yii::t('app', 'Shift copy ID'),
            'hash' => Yii::t('app', 'Hash'),
        ];
        return array_merge(parent::attributeLabels(), $labels);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShift()
    {
        return $this->hasOne(Shift::className(), ['id' => 'shiftId']);
    }

    /**
     * @inheritdoc
     * @return ShiftCopyLogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ShiftCopyLogQuery(get_called_class());
    }
}
