<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "addresstype".
 *
 * @property integer $idaddresstypes
 * @property string $addresstype
 *
 * @property Companyaddress[] $companyaddresses
 */
class Addresstype extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'addresstype';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['addresstype'], 'required'],
            [['addresstype'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idaddresstypes' => Yii::t('app', 'Idaddresstypes'),
            'addresstype' => Yii::t('app', 'Addresstype'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyaddresses()
    {
        return $this->hasMany(Companyaddress::className(), ['addresstype' => 'idaddresstypes']);
    }
}
