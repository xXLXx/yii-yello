<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "Franchiser".
 *
 * @property integer $id
 * @property integer $companyId
 * @property integer $userId
 * @property integer $corporateScheduleId
 * 
 * @property Company $company company
 */
class Franchiser extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Franchiser';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            [['companyId', 'userId', 'corporateScheduleId'], 'integer']
        ];
        return array_merge(parent::rules(), $rules);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'companyId']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = [
            'id' => Yii::t('app', 'ID'),
            'companyId' => Yii::t('app', 'Company ID'),
            'userId' => Yii::t('app', 'User ID'),
            'corporateScheduleId' => Yii::t('app', 'Corporate Schedule ID'),
        ];
        return array_merge(parent::attributeLabels(), $labels);
    }
}
