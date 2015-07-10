<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "DriverHasSuburb".
 *
 * @property integer $id
 * @property integer $driverId
 * @property integer $suburbId
 */
class DriverHasSuburb extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'DriverHasSuburb';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            [['driverId', 'suburbId'], 'integer'],
        ];
        return array_merge(parent::rules(), $rules);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $attributeLabels = [
            'id' => Yii::t('app', 'ID'),
            'driverId' => Yii::t('app', 'Driver ID'),
            'suburbId' => Yii::t('app', 'Suburb ID'),
        ];
        return array_merge(parent::attributeLabels(), $attributeLabels);
    }
}
