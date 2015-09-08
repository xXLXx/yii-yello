<?php

namespace common\models;

use common\behaviors\DatetimeFormatBehavior;
use common\behaviors\shift\ShiftStateBehavior;
use common\components\Formatter;
use Yii;
use common\models\search\ShiftSearch;
use yii\data\ActiveDataProvider;
use common\helpers\ArrayHelper;
use common\models\Store;

/**
 * This is the model class for table "Shift".
 * Class Shift
 * @package \common\models
 *
 * @property Store[] $stores
 */
class ShiftReviews extends BaseModel
{
    public static function tableName()
    {
        return 'ShiftReviews';
    }
    /**
     * @inheritdoc
     */
    /*public function behaviors()
    {
        $behaviors = [
            'ShiftStateBehavior' => ShiftStateBehavior::className(),
            [
                'class' => DatetimeFormatBehavior::className(),
                DatetimeFormatBehavior::ATTRIBUTES_STRING => [
                    'start',
                    'end',
                    'actualStart',
                    'actualEnd',
                ],
                DatetimeFormatBehavior::ATTRIBUTES_TIMESTAMP => [
                    'createdAt',
                    'updatedAt',
                ],
            ]
        ];
        return array_merge(parent::behaviors(), $behaviors);
    }*/

    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        return [
            'store'
        ];
    }

    /**
     * Get Shift's store
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStore()
    {
        $store = $this->getClassName('Store');
        return $this
            ->hasOne(
                $store,
                [
                    'id' => 'storeId',
                ]
            );
    }

}
