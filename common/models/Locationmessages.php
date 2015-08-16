<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "locationmessages".
 *
 * @property integer $idlocationmessages
 * @property integer $driverid
 * @property integer $storeid
 * @property string $latitude
 * @property string $longitude
 * @property integer $unixtimestamp
 */
class Locationmessages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'locationmessages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idlocationmessages'], 'required'],
            [['idlocationmessages', 'driverid', 'storeid', 'unixtimestamp'], 'integer'],
            [['latitude', 'longitude'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idlocationmessages' => Yii::t('app', 'Idlocationmessages'),
            'driverid' => Yii::t('app', 'Driverid'),
            'storeid' => Yii::t('app', 'Storeid'),
            'latitude' => Yii::t('app', 'Latitude'),
            'longitude' => Yii::t('app', 'Longitude'),
            'unixtimestamp' => Yii::t('app', 'Unixtimestamp'),
        ];
    }
}
