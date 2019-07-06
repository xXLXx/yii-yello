<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\models\query\StoreOwnerFavouriteDriversQuery;

/**
 * This is the model class for table "StoreOwnerFavouriteDrivers".
 *
 * @property integer $id
 * @property integer $storeOwnerId
 * @property integer $driverId
 * @property integer $createdAt
 * @property integer $updatedAt
 * @property integer $isArchived
 * @property integer $storefk
 */
class StoreOwnerFavouriteDrivers extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'StoreOwnerFavouriteDrivers';
    }

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
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['storeOwnerId', 'driverId', 'storefk'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     * @return StoreOwnerFavouriteDriversQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StoreOwnerFavouriteDriversQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'storeOwnerId' => 'Store Owner ID',
            'driverId' => 'Driver ID',
            'createdAt' => 'Created At',
            'updatedAt' => 'Updated At',
            'isArchived' => 'Is Archived',
            'storefk' => 'Store ID'
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getDriver()
    {
        return $this->hasOne(
            static::getClassName('Driver'),
            [
                'id' => 'driverId',
            ]
        );
    }
}