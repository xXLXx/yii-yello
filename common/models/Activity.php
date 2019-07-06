<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "Activity".
 *
 * @property integer $id
 * @property string $name
 * @property integer $userId
 *
 * @property User $user
 * @property ActivityParam[] $activityParams
 */
class Activity extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Activity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            [['userId'], 'integer'],
            [['name'], 'string', 'max' => 255]
        ];
        return array_merge(parent::rules(), $rules);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'userId' => Yii::t('app', 'User ID')
        ];
        return array_merge(parent::attributeLabels(), $labels);
    }

    /**
     * Set params
     * 
     * @param array $params
     */
    public function setParams($params)
    {
        foreach ($params as $field => $value) {
            $activityParam = new ActivityParam();
            $activityParam->field = $field;
            $activityParam->value = $value;
            $activityParam->activityId = $this->id;
            $activityParam->save();
        }
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivityParams()
    {
        return $this->hasMany(ActivityParam::className(), ['activityId' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\query\ActivityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ActivityQuery(get_called_class());
    }
}
