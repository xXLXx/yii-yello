<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "VehicleType".
 *
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property integer $createdAt
 * @property integer $updatedAt
 * @property integer $isArchived
 */
class VehicleType extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'VehicleType';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['createdAt', 'updatedAt'], 'required'],
            [['createdAt', 'updatedAt', 'isArchived'], 'integer'],
            [['name', 'title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'title' => Yii::t('app', 'Title'),
            'createdAt' => Yii::t('app', 'Created At'),
            'updatedAt' => Yii::t('app', 'Updated At'),
            'isArchived' => Yii::t('app', 'Is Archived'),
        ];
    }
    
    /**
     * Get vehicles
     * 
     * @return \yii\db\ActiveQuery
     */
    public function getVehicles()
    {
        return $this->hasMany(Vehicle::className(), ['vehicleTypeId' => 'id']);
    }
}
