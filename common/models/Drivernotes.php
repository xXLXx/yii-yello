<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "drivernotes".
 *
 * @property integer $id
 * @property integer $driverId
 * @property integer $storeId
 * @property string $note
 * @property integer $createdAt
 * @property integer $updatedAt
 * @property integer $isArchived
 *
 * @property User $driver
 * @property Store $store
 */
class Drivernotes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'drivernotes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['driverId', 'storeId', 'note', 'createdAt', 'updatedAt', 'isArchived'], 'required'],
            [['driverId', 'storeId', 'createdAt', 'updatedAt', 'isArchived'], 'integer'],
            [['note'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'driverId' => Yii::t('app', 'Driver ID'),
            'storeId' => Yii::t('app', 'Store ID'),
            'note' => Yii::t('app', 'Note'),
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
    public function getStore()
    {
        return $this->hasOne(Store::className(), ['id' => 'storeId']);
    }
}
