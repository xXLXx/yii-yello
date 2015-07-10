<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "Suburb".
 *
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property integer $cityId
 * 
 * @property City $city
 * @property DriverHasSuburb[] $driverHasSuburbs driver has suburbs
 * @property Driver[] $drivers drivers
 */
class Suburb extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Suburb';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cityId', 'createdAt', 'updatedAt', 'isArchived'], 'integer'],
            [['createdAt', 'updatedAt'], 'required'],
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
            'cityId' => Yii::t('app', 'City ID'),
            'createdAt' => Yii::t('app', 'Created At'),
            'updatedAt' => Yii::t('app', 'Updated At'),
            'isArchived' => Yii::t('app', 'Is Archived'),
        ];
    }
    
    /**
     * Get city
     * 
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'cityId']);
    }
    
    /**
     * Get DriverHasSuburbs
     * 
     * @return \yii\db\ActiveQuery
     */
    public function getDriverHasSuburbs()
    {
        return $this->hasMany(
            DriverHasSuburb::className(), ['suburbId' => 'id']
        );
    }
    
    /**
     * Get drivers
     * 
     * @return \yii\db\ActiveQuery
     */
    public function getDrivers()
    {
        return $this->hasMany(Driver::className(), ['id' => 'driverId'])
            ->via('driverHasSuburbs');
    }
}
