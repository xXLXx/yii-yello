<?php

namespace common\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "store".
 *
 * @property integer $id
 * @property integer $companyId
 * @property integer $businessTypeId
 * @property integer $storeOwnerId
 * @property integer $paymentScheduleId
 * @property integer $imageId
 * @property string $title
 * @property string $website
 * @property string $businessHours
 * @property string $storeProfile
 * @property integer $createdAt
 * @property integer $updatedAt
 * @property integer $isArchived
 *
 * @property Driverhasstore[] $driverhasstores
 * @property Shift[] $shifts
 * @property Businesstype $businessType
 * @property Company $company
 * @property Image $image
 * @property Storeowner $storeOwner
 * @property Userhasstore[] $userhasstores
 * @property Address $address
 * @property StoreAddress $storeAddress
 * @property string $timezone
 */
class Store extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'store';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['companyId', 'businessTypeId', 'storeOwnerId', 'paymentScheduleId', 'imageId', 'createdAt', 'updatedAt', 'isArchived'], 'integer'],
            [['title', 'website', 'businessHours', 'storeProfile'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'companyId' => Yii::t('app', 'Company ID'),
            'businessTypeId' => Yii::t('app', 'Business Type ID'),
            'storeOwnerId' => Yii::t('app', 'Store Owner ID'),
            'paymentScheduleId' => Yii::t('app', 'Payment Schedule ID'),
            'imageId' => Yii::t('app', 'Image ID'),
            'title' => Yii::t('app', 'Title'),
            'website' => Yii::t('app', 'Website'),
            'businessHours' => Yii::t('app', 'Business Hours'),
            'storeProfile' => Yii::t('app', 'Store Profile'),
            'createdAt' => Yii::t('app', 'Created At'),
            'updatedAt' => Yii::t('app', 'Updated At'),
            'isArchived' => Yii::t('app', 'Is Archived'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDriverhasstores()
    {
        return $this->hasMany(Driverhasstore::className(), ['storeId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShifts()
    {
        return $this->hasMany(Shift::className(), ['storeId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBusinessType()
    {
        return $this->hasOne(Businesstype::className(), ['id' => 'businessTypeId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'companyId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'imageId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStoreOwner()
    {
        return $this->hasOne(Storeowner::className(), ['id' => 'storeOwnerId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserhasstores()
    {
        return $this->hasMany(Userhasstore::className(), ['storeId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddress()
    {
        return $this->hasOne(Address::className(), ['idaddress' => 'addressfk'])
            ->viaTable('storeaddress', ['storefk' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStoreAddress()
    {
        return $this->hasOne(StoreAddress::className(), ['storefk' => 'id']);
    }

    /**
     * Retrieve timezone from its address.
     *
     * @return string timezone
     */
    public function getTimezone()
    {
        return !empty($this->address->timezone) ? $this->address->timezone : 'Australia/Sydney';
    }

    /**
     * The path pattern.
     *
     * @return string
     */
    public function getLogoPathPattern()
    {
        return '/store/{id}/logo.png';
    }


    /**
     * The store logo url.
     *
     * @return string
     */
    public function getLogoUrl()
    {
        return \Yii::$app->params['uploadPath'].str_replace('{id}', $this->id, $this->getLogoPathPattern());
    }

    /**
     * @param \DateTime $date
     *
     * @return \yii\data\ActiveDataProvider
     */
    public function getAssignedShiftsByDate( \DateTime $date = null )
    {
        if ( $date === null ) {
            $date = new \DateTime();
        }

        $dayStart = $date->format('Y-m-d 00:00:00');
        $dayEnd = $date->format('Y-m-d 23:59:59');

        $shiftsDataProvider = new ActiveDataProvider([
            'query' => $this
                ->getShifts()
                ->innerJoin('ShiftState', 'Shift.shiftStateId = ShiftState.id')
                ->where(['ShiftState.name' => ShiftState::getStatesForShiftList()])
                ->andWhere(['between', 'Shift.start', $dayStart, $dayEnd])
                ->orderBy(['Shift.start' => SORT_ASC]),
            'pagination' => false,
        ]);

        return $shiftsDataProvider;
    }
}
