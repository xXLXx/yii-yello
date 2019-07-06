<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "addresstype".
 *
 * @property integer $idaddresstypes
 * @property string $addresstype
 *
 * @property CompanyAddress[] $companyaddresses
 */
class AddressType extends \yii\db\ActiveRecord
{
    const TYPE_POSTAL = 'postal';
    const TYPE_LOCATION = 'location';

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
     * @inheritdoc
     *
     * @return \common\models\query\AddressTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\AddressTypeQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyaddresses()
    {
        return $this->hasMany(CompanyAddress::className(), ['addresstype' => 'idaddresstypes']);
    }
}
