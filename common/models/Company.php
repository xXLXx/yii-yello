<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "Company".
 *
 * @property integer $id
 * @property string $accountName
 * @property string $companyName
 * @property string $address1
 * @property string $address2
 * @property string $postcode
 * @property integer $suburb
 * @property integer $stateId
 * @property string $contactPerson
 * @property string $phone
 * @property string $website
 * @property string $ABN
 * @property integer $imageId
 * @property string $email
 * @property integer $country
 * @property integer $timeFormatId
 * @property integer $timeZoneId
 * @property integer $currencyId
 * 
 * @property Store[] $stores stores
 * @property Image $image logo image
 */
class Company extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Company';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            [['stateId', 'timeZoneId', 'timeFormatId', 'currencyId', 'imageId'], 'integer'],
            [['contactPerson'], 'string'],
            [['companyName', 'suburb', 'postcode', 'address1', 'address2', 
                'accountName', 'phone', 'website', 'ABN', 'email'],
                'string', 'max' => 255]
        ];
        return array_merge(parent::rules(), $rules);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStores()
    {
        return $this->hasMany(Store::className(), ['companyId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'imageId']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = [
            'id' => Yii::t('app', 'ID'),
            'companyName' => Yii::t('app', 'Company Name'),
            'address1' => Yii::t('app', 'Address1'),
            'address2' => Yii::t('app', 'Address2'),
            'suburb' => Yii::t('app', 'Suburb'),
            'stateId' => Yii::t('app', 'State ID'),
            'contactPerson' => Yii::t('app', 'Contact Person'),
            'phone' => Yii::t('app', 'Phone'),
            'website' => Yii::t('app', 'Website'),
            'ABN' => Yii::t('app', 'Abn'),
            'imageId' => Yii::t('app', 'Image ID'),
            'email' => Yii::t('app', 'Email'),
        ];
        return array_merge(parent::attributeLabels(), $labels);
    }
}
