<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "companyaddress".
 *
 * @property integer $idcompanyaddress
 * @property integer $companyfk
 * @property integer $addressfk
 * @property integer $addresstype
 * @property string $addresstitle
 * @property string $contact_name
 * @property string $contact_phone
 * @property string $contact_email
 * @property integer $createdUTC
 * @property integer $updatedUTC
 * @property integer $isarchived
 *
 * @property Company $companyfk0
 * @property Address $addressfk0
 * @property Addresstype $addresstype0
 */
class Companyaddress extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'companyaddress';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['companyfk', 'addressfk'], 'required'],
            [['companyfk', 'addressfk', 'addresstype', 'createdUTC', 'updatedUTC', 'isarchived'], 'integer'],
            [['addresstitle', 'contact_name'], 'string', 'max' => 200],
            [['contact_phone'], 'string', 'max' => 24],
            [['contact_email'], 'string', 'max' => 400]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idcompanyaddress' => Yii::t('app', 'Idcompanyaddress'),
            'companyfk' => Yii::t('app', 'Companyfk'),
            'addressfk' => Yii::t('app', 'Addressfk'),
            'addresstype' => Yii::t('app', 'Addresstype'),
            'addresstitle' => Yii::t('app', 'Addresstitle'),
            'contact_name' => Yii::t('app', 'Contact Name'),
            'contact_phone' => Yii::t('app', 'Contact Phone'),
            'contact_email' => Yii::t('app', 'Contact Email'),
            'createdUTC' => Yii::t('app', 'Created Utc'),
            'updatedUTC' => Yii::t('app', 'Updated Utc'),
            'isarchived' => Yii::t('app', 'Isarchived'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyfk0()
    {
        return $this->hasOne(Company::className(), ['id' => 'companyfk']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddressfk0()
    {
        return $this->hasOne(Address::className(), ['idaddress' => 'addressfk']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddresstype0()
    {
        return $this->hasOne(Addresstype::className(), ['idaddresstypes' => 'addresstype']);
    }
}
