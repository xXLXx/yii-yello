<?php

namespace frontend\models;

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
    public $abn;
    
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

    /**
     * @inheritdoc
     */
    public function rules() 
    {
        return [
            [['id'], 'integer'],
            [['contact_email'], 'email'],
            [['accountName', 'companyName', 'abn', 'block_or_unit', 'street_number', 'route', 'locality', 'administrative_area_level_1','postal_code','country'], 'string'],
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
     * Set data from StoreOwner
     * 
     * @param StoreOwner $storeOwner storeOwner
     */
    public function setData( StoreOwner $storeOwner)
    {
        $company = $storeOwner->company;
        if (!$company) {
            $company = new Company();
            $company->save();
            $storeOwner->companyId = $company->id;
            $storeOwner->save();
        }
        $this->setAttributes($company->getAttributes());
    }
    
    /**
     * Save
     */
    public function save() 
    {
        $company = Company::findOne($this->id);
        $company->setAttributes($this->getAttributes());
        $company->save();
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
