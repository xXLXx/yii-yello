<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

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
 * @property Company $company
 * @property Address $address
 * @property AddressType $addressType
 */
class CompanyAddress extends BaseModel
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
            ['addresstitle', 'default', 'value' => 'Default'],
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
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['createdUTC', 'updatedUTC'],
                    self::EVENT_BEFORE_UPDATE => ['updatedUTC'],
                ],
            ]
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'companyfk']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddress()
    {
        return $this->hasOne(Address::className(), ['idaddress' => 'addressfk']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddressType()
    {
        return $this->hasOne(AddressType::className(), ['idaddresstypes' => 'addresstype']);
    }
}
