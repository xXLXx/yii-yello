<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "StoreOwnerFavouriteDrivers".
 *
 * @property integer $id
 * @property integer $storeOwnerId
 * @property integer $driverId
 * @property integer $createdAt
 * @property integer $updatedAt
 * @property integer $isArchived
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
            [['storeOwnerId', 'driverId'], 'integer']
        ];
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
        ];
    }
}
