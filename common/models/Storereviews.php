<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "storereviews".
 *
 * @property integer $id
 * @property string $text
 * @property double $stars
 * @property integer $shiftId
 * @property integer $storeId
 * @property integer $driverId
 * @property integer $createdAt
 * @property integer $updatedAt
 * @property integer $isArchived
 *
 * @property User $driver
 * @property Shift $shift
 * @property Store $store
 */
class Storereviews extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'storereviews';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text', 'stars', 'shiftId', 'storeId', 'driverId', 'createdAt', 'updatedAt', 'isArchived'], 'required'],
            [['text'], 'string'],
            [['stars'], 'number'],
            [['shiftId', 'storeId', 'driverId', 'createdAt', 'updatedAt', 'isArchived'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'text' => Yii::t('app', 'Text'),
            'stars' => Yii::t('app', 'Stars'),
            'shiftId' => Yii::t('app', 'Shift ID'),
            'storeId' => Yii::t('app', 'Store ID'),
            'driverId' => Yii::t('app', 'Driver ID'),
            'createdAt' => Yii::t('app', 'Created At'),
            'updatedAt' => Yii::t('app', 'Updated At'),
            'isArchived' => Yii::t('app', 'Is Archived'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDriver()
    {
        return $this->hasOne(User::className(), ['id' => 'driverId']);
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
    public function getStore()
    {
        return $this->hasOne(Store::className(), ['id' => 'storeId']);
    }
}
