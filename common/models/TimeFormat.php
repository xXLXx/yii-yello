<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "TimeFormat".
 *
 * @property integer $id
 * @property string $title
 * @property string $name
 * @property integer $createdAt
 * @property integer $updatedAt
 * @property integer $isArchived
 */
class TimeFormat extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'TimeFormat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['createdAt', 'updatedAt'], 'required'],
            [['createdAt', 'updatedAt', 'isArchived'], 'integer'],
            [['title', 'name'], 'string', 'max' => 255]
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
            'name' => Yii::t('app', 'Name'),
            'createdAt' => Yii::t('app', 'Created At'),
            'updatedAt' => Yii::t('app', 'Updated At'),
            'isArchived' => Yii::t('app', 'Is Archived'),
        ];
    }
}
