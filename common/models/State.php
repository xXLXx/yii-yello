<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "State".
 *
 * @property integer $id
 * @property integer $countryId
 * @property string $title
 * 
 * @property City[] $cities cities
 */
class State extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'State';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['countryId'], 'integer'],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'countryId' => Yii::t('app', 'Country ID'),
            'title' => Yii::t('app', 'Title'),
        ];
    }
    
    /**
     * Get cities
     * 
     * @return \yii\db\ActiveQuery
     */
    public function getCities()
    {
        return $this->hasMany(City::className(), ['stateId' => 'id']);
    }
}
