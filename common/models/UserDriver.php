<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "UserDriver".
 *
 * @property integer $id
 * @property string $driverLicenseNumber
 * @property string $driverLicensePhoto
 * @property string $personalProfile
 * @property string $emergencyContactName
 * @property string $emergencyContactPhone
 * @property string $availability
 * @property integer $isAllowedToWorkInAustralia
 * @property integer $isAccredited
 * @property string $paymentMethod
 * @property double $rating
 * @property string $status
 * @property integer $userId
 * @property string $bankName
 * @property string $bsb
 * @property integer $accountNumber
 * @property boolean $isAllowedToReceiveNotifications
 * @property boolean $isAvailableToWork
 *
 */
class UserDriver extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'UserDriver';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            [['isAllowedToWorkInAustralia', 'isAccredited', 'userId'], 'integer'],
            [['isAllowedToReceiveNotifications', 'isAvailableToWork'], 'boolean'],
//            [   [
//                    'userId'
//                ],
//                'unique', 'targetAttribute' => 'id',
//                'targetClass' => 'common\\models\\User'
//            ],
            [['userId'], 'unique'],
            [['rating'], 'number'],
            [   
                [
                    'driverLicenseNumber', 'driverLicensePhoto', 'personalProfile', 
                    'emergencyContactName', 'emergencyContactPhone', 'availability', 
                    'paymentMethod', 'status', 'bankName', 'bsb', 'accountNumber'
                ],
                'string',
                'max' => 255
            ]
        ];
        return array_merge(parent::rules(), $rules);
    }

    /**
     * Override BaseModel default timestamp behavior
     *
     * @inheritdoc
     */
    public function behaviors()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = [
            'id' => Yii::t('app', 'ID'),
            'driverLicenseNumber' => Yii::t('app', 'Driver License Number'),
            'driverLicensePhoto' => Yii::t('app', 'Driver License Photo'),
            'userId' => Yii::t('app', 'User ID'),
            'personalProfile' => Yii::t('app', 'Personal Profile'),
            'emergencyContactName' => Yii::t('app', 'Emergency Contact Name'),
            'emergencyContactPhone' => Yii::t('app', 'Emergency Contact Phone'),
            'availability' => Yii::t('app', 'Availability'),
            'isAllowedToWorkInAustralia' => Yii::t('app', 'Is Allowed To Work In Australia'),
            'isAccredited' => Yii::t('app', 'Is Accredited'),
            'isAllowedToReceiveNotifications' => Yii::t('app', 'Allows to receive notifications'),
            'isAvailableToWork' => Yii::t('app', 'Available to work'),
            'paymentMethod' => Yii::t('app', 'Payment Method'),
            'rating' => Yii::t('app', 'Rating'),
            'status' => Yii::t('app', 'Status'),
        ];
        return array_merge(parent::attributeLabels(), $labels);
    }

    /**
     * Get city
     * 
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'cityId']);
    }
    


    /**
     * Get city
     * 
     * @return \yii\db\ActiveQuery
     */
    public function getState()
    {
        return $this->hasOne(State::className(), ['id' => 'stateId']);
    }
        
    
    /**
     * Get user
     * 
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }
}
