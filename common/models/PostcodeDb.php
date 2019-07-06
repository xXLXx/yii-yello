<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "postcode_db".
 *
 * @property string $postcode
 * @property string $suburb
 * @property string $state
 * @property string $dc
 * @property string $type
 * @property double $lat
 * @property double $lon
 */
class PostcodeDb extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'postcode_db';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['postcode', 'suburb', 'state', 'dc', 'type'], 'required'],
            [['postcode'], 'integer'],
            [['lat', 'lon'], 'number'],
            [['suburb', 'dc', 'type'], 'string', 'max' => 45],
            [['state'], 'string', 'max' => 4]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'postcode' => Yii::t('app', 'Postcode'),
            'suburb' => Yii::t('app', 'Suburb'),
            'state' => Yii::t('app', 'State'),
            'dc' => Yii::t('app', 'Dc'),
            'type' => Yii::t('app', 'Type'),
            'lat' => Yii::t('app', 'Lat'),
            'lon' => Yii::t('app', 'Lon'),
        ];
    }
}
