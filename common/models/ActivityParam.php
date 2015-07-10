<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ActivityParam".
 *
 * @property integer $id
 * @property string $field
 * @property string $value
 * @property integer $activityId
 *
 * @property Activity $activity
 */
class ActivityParam extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ActivityParam';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            [['value'], 'safe'],
            [['activityId'], 'integer'],
            [['field'], 'string', 'max' => 255]
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
            'field' => Yii::t('app', 'Field'),
            'value' => Yii::t('app', 'Value'),
            'activityId' => Yii::t('app', 'Activity ID')
        ];
        return array_merge(parent::attributeLabels(), $labels);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getActivity()
    {
        return $this->hasOne(Activity::className(), ['id' => 'activityId']);
    }

    /**
     * @inheritdoc
     * @return \common\models\query\ActivityParamQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\ActivityParamQuery(get_called_class());
    }
}
