<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "companytype".
 *
 * @property integer $idcompanytype
 * @property string $companytype
 *
 * @property Company $idcompanytype0
 */
class Companytype extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'companytype';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['companytype'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idcompanytype' => Yii::t('app', 'Idcompanytype'),
            'companytype' => Yii::t('app', 'Companytype'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdcompanytype0()
    {
        return $this->hasOne(Company::className(), ['companyType' => 'idcompanytype']);
    }
}
