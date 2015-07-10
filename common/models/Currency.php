<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "Currency".
 *
 * @property integer $id
 * @property string $title
 * @property string $rate
 */
class Currency extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Currency';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rate'], 'number'],
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
            'title' => Yii::t('app', 'Title'),
            'rate' => Yii::t('app', 'Rate'),
        ];
    }
}
