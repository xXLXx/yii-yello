<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "City".
 *
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property integer $stateId
 * 
 * @property State $state state
 * @property Suburb[] $suburbs suburbs
 */
class City extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'City';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stateId', 'createdAt', 'updatedAt', 'isArchived'], 'integer'],
            [['createdAt', 'updatedAt'], 'required'],
            [['name', 'title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'title' => Yii::t('app', 'Title'),
            'stateId' => Yii::t('app', 'State ID'),
            'createdAt' => Yii::t('app', 'Created At'),
            'updatedAt' => Yii::t('app', 'Updated At'),
            'isArchived' => Yii::t('app', 'Is Archived'),
        ];
    }
    
    /**
     * Get state
     * 
     * @return \yii\db\ActiveQuery
     */
    public function getState()
    {
        return $this->hasOne(State::className(), ['id' => 'stateId']);
    }
    
    /**
     * Get suburbs
     * 
     * @return \yii\db\ActiveQuery
     */
    public function getSuburbs()
    {
        return $this->hasMany(Suburb::className(), ['cityId' => 'id']);
    }
}
