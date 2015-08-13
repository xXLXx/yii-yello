<?php

namespace frontend\models;

use common\models\Address;
use common\models\AddressType;
use common\models\Companyaddress;
use yii\base\Model;
use common\models\TimeZone;
use common\models\Currency;
use common\models\Country;
use common\models\TimeFormat;
use common\models\State;
use common\models\Company;
use common\models\StoreOwner;

/**
 * Company form
 *
 * @author markov
 */
class CompanyForm extends Model
{
    public $id;
    public $accountName;
    public $companyName;
    public $ABN; // to match company.ABN field
    
    public $contact_name;
    public $contact_phone;
    public $contact_email;
    public $website;

    public $block_or_unit;
    public $street_number;
    public $route;
    public $locality;
    public $administrative_area_level_1;
    public $postal_code;
    public $country;
    public $formatted_address;
    public $latitude;
    public $longitude;
    public $googleplaceid;
    public $googleobj;

    /**
     * @inheritdoc
     */
    public function rules() 
    {
        return [
            [['id'], 'integer'],
            [['contact_email'], 'email'],
            [['accountName', 'companyName', 'ABN', 'block_or_unit', 'street_number', 'route', 'locality',
                'administrative_area_level_1','postal_code','country', 'formatted_address', 'contact_name',
                'contact_phone', 'contact_email', 'website', 'latitude', 'longitude','googleplaceid','googleobj'], 'string'],
        ];
    }

    
    public function attributeLabels()
    {
        $labels = [
            'street_number' => '',
            'route' => '',
            'administrative_area_level_1'=> \Yii::t('app', 'State'),
            'postal_code'=> \Yii::t('app', 'Postcode'),
            'locality'=> \Yii::t('app', 'Suburb')
            
        ];
        return array_merge(parent::attributeLabels(), $labels);
    }    
    
    
    /**
     * Set data from everywhere
     * 
     * @param StoreOwner $storeOwner storeOwner
     */
    public function setData($user)
    {
        $owner = $user->storeOwner;
        $company=$owner->company;
        if (!$company) {
            $company = new Company();
            $company->save();
            $storeOwner->companyId = $company->id;
            $storeOwner->save();
        }
        $this->setAttributes($company->getAttributes());

        $companyAddress = CompanyAddress::findOneOrCreate(array('companyfk' => $company->id));
        $this->setAttributes($companyAddress->getAttributes());

        $address = Address::findOneOrCreate($companyAddress->addressfk);
        $this->setAttributes($address->getAttributes());
    }
    
    /**
     * Save
     */
    public function save() 
    {
        $transaction = \Yii::$app->db->beginTransaction();

//        try {
            $company = Company::findOneOrCreate($this->id);
            $company->ABN = $this->ABN;
            $company->accountName = $this->accountName;
            $company->companyName = $this->companyName;
            $company->website = $this->website;

            if (!$company->save()) {
                $error = $company->getFirstError();
                $this->addError(key($error), current($error));

                throw new \yii\db\Exception(current($error));
            }

            $this->id = $company->id;

            $companyAddress = CompanyAddress::findOneOrCreate(array(
                'companyfk' => $this->id,
            ));

            // This will create new (default) address if addressfk is null yet.
            $address = Address::findOneOrCreate(array(
                'idaddress' => $companyAddress->addressfk,
            ));
            $address->block_or_unit = $this->block_or_unit;
            $address->street_number = $this->street_number;
            $address->route = $this->route;
            $address->locality = $this->locality;
            $address->administrative_area_level_1 = $this->administrative_area_level_1;
            $address->postal_code = $this->postal_code;
            $address->country = $this->country;
            $address->formatted_address = $this->formatted_address;
            $address->latitude = $this->latitude;
            $address->longitude = $this->longitude;

            if (!$address->save()) {
                $error = $address->getFirstError();
                $this->addError(key($error), current($error));

                throw new \yii\db\Exception(current($error));
            }

            $companyAddress->addressfk = $address->idaddress;
            $companyAddress->companyfk = $this->id;
            $companyAddress->contact_name = $this->contact_name;
            $companyAddress->contact_phone = $this->contact_phone;
            $companyAddress->contact_email = $this->contact_email;
            $companyAddress->addresstype = AddressType::find()->byType(AddressType::TYPE_POSTAL)->one()->idaddresstypes;

            if (!$companyAddress->save()) {
                $error = $companyAddress->getFirstError();
                $this->addError(key($error), current($error));

                throw new \yii\db\Exception(current($error));
            }



            $transaction->commit();
            return true;
//        } catch (\Exception $e) {
//            \Yii::error($e->getMessage());
//            $transaction->rollBack();
//        }

        return false;
    }
    
    /**
     * Get timezones
     * 
     * @return array 
     */
    public function getTimeZoneArrayMap()
    {
        $timezones = TimeZone::find()
            ->select(['id', 'text'])
            ->asArray()
            ->all();
        $result = [
            null => \Yii::t('app', 'Select time zone')
        ];
        foreach ($timezones as $item) {
            $result[$item['id']] = $item['text'];
        }
        return $result;
    }
    
    /**
     * Get timeformats
     * 
     * @return array 
     */
    public function getTimeFormatArrayMap()
    {
        $timeformats = TimeFormat::find()
            ->select(['id', 'title'])
            ->asArray()
            ->all();
        $result = [
            null => \Yii::t('app', 'Select time format')
        ];
        foreach ($timeformats as $item) {
            $result[$item['id']] = $item['title'];
        }
        return $result;
    }
    
    /**
     * Get currencies
     * 
     * @return array 
     */
    public function getCurrencyArrayMap()
    {
        $currencies = Currency::find()
            ->select(['id', 'code'])
            ->asArray()
            ->all();
        $result = [
            null => \Yii::t('app', 'Select currency')
        ];
        foreach ($currencies as $item) {
            $result[$item['id']] = $item['code'];
        }
        return $result;
    }
    
    /**
     * Get countries
     * 
     * @return array 
     */
    public function getCountryArrayMap()
    {
        $countries = Country::find()
            ->select(['id', 'title'])
            ->asArray()
            ->all();
        $result = [
            null => \Yii::t('app', 'Select country')
        ];
        foreach ($countries as $item) {
            $result[$item['id']] = $item['title'];
        }
        return $result;
    }
    
    /**
     * Get states
     * 
     * @return array 
     */
    public function getStateArrayMap()
    {
        $countries = State::find()
            ->select(['id', 'title'])
            ->andFilterWhere(['countryId' => $this->countryId])
            ->asArray()
            ->all();
        $result = [
            null => \Yii::t('app', 'Select state')
        ];
        foreach ($countries as $item) {
            $result[$item['id']] = $item['title'];
        }
        return $result;
    }
}
