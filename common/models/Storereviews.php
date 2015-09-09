<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "storereviews".
 *
 * @property integer $id
 * @property string $text
 * @property double $stars
 * @property integer $storeId
 * @property integer $driverId
 * @property integer $createdAt
 * @property integer $updatedAt
 * @property integer $isArchived
 *
 * @property User $driver
 * @property Store $store
 */
class Storereviews extends BaseModel
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
            [['text', 'stars', 'storeId', 'driverId'], 'required'],
            [['text'], 'string'],
            [['stars'], 'number'],
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
            'storeId' => Yii::t('app', 'Store ID'),
            'driverId' => Yii::t('app', 'Driver ID'),
            'createdAt' => Yii::t('app', 'Created At'),
            'updatedAt' => Yii::t('app', 'Updated At'),
            'isArchived' => Yii::t('app', 'Is Archived'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        return [
            'driver',
            'store',
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
    public function getStore()
    {
        return $this->hasOne(Store::className(), ['id' => 'storeId']);
    }
}
