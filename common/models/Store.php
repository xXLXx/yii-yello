<?php

namespace common\models;

use common\behaviors\DatetimeFormatBehavior;
use Faker\Provider\cs_CZ\DateTime;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "Store".
 *
 * @property integer $id
 * @property string $title
 * @property integer $businessTypeId
 * @property integer $companyId
 * @property integer $paymentScheduleId
 * @property string $address1
 * @property string $address2
 * @property string $suburb
 * @property integer $stateId
 * @property string $contactPerson
 * @property string $phone
 * @property string $abn
 * @property string $website
 * @property string $email
 * @property string $businessHours
 * @property string $storeProfile
 * @property integer $imageId
 * @property string $createdAtAsDatetime
 * @property string $updatedAtAsDatetime
 * @property Image $image image
 *
 * @property Company $company company
 * @property Shift[] $shifts
 */
class Store extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Store';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            [['businessTypeId', 'companyId', 'paymentScheduleId', 'stateId', 'imageId'], 'integer'],
            [['title', 'address1', 'address2', 'suburb', 'contactPerson', 'phone', 'abn', 'website', 'email',
            'businessHours', 'storeProfile'], 'string', 'max' => 255]
        ];
        return array_merge(parent::rules(), $rules);
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors[] = [
            'class' => DatetimeFormatBehavior::className(),
            DatetimeFormatBehavior::ATTRIBUTES_TIMESTAMP => ['createdAt', 'updatedAt'],
        ];
        return $behaviors;
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
    public function getShifts()
    {
        return $this->hasMany(Shift::className(), ['storeId' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'businessTypeId' => Yii::t('app', 'Business Type ID'),
            'companyId' => Yii::t('app', 'Company ID'),
            'paymentScheduleId' => Yii::t('app', 'Payment Schedule ID'),
        ];
        return array_merge(parent::attributeLabels(), $labels);
    }

    /**
     * Get Image
     */
    public function getImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'imageId']);
    }

    /**
     * @param \DateTime $date
     *
     * @return ActiveDataProvider
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
