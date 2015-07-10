<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "TimeZone".
 *
 * @property integer $id
 * @property string $title
 * @property string $zone
 */
class TimeZone extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'TimeZone';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'zone'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'zone' => Yii::t('app', 'Zone'),
        ];
    }
}
