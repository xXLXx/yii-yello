<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "Company".
 *
 * @property integer $id
 * @property integer $companyType
 * @property integer $userfk
 * @property integer $registeredForGST
 * @property string $accountName
 * @property string $companyName
 * @property string $ABN
 * @property string $website
 * @property integer $imageId
 * @property string $email
 * @property integer $createdAt
 * @property integer $updatedAt
 * @property integer $isArchived
 * @property integer $timeFormatId
 * @property integer $isPrimary
 */
class Company extends BaseModel
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
        return [
            [['companyType', 'userfk', 'registeredForGST', 'imageId', 'createdAt', 'updatedAt', 'isArchived', 'timeFormatId', 'isPrimary'], 'integer'],
            [['accountName', 'companyName', 'ABN', 'website'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 400]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'companyType' => Yii::t('app', 'Company Type'),
            'userfk' => Yii::t('app', 'Userfk'),
            'registeredForGST' => Yii::t('app', 'Registered For Gst'),
            'accountName' => Yii::t('app', 'Account Name'),
            'companyName' => Yii::t('app', 'Company Name'),
            'ABN' => Yii::t('app', 'Abn'),
            'website' => Yii::t('app', 'Website'),
            'imageId' => Yii::t('app', 'Image ID'),
            'email' => Yii::t('app', 'Email'),
            'createdAt' => Yii::t('app', 'Created At'),
            'updatedAt' => Yii::t('app', 'Updated At'),
            'isArchived' => Yii::t('app', 'Is Archived'),
            'timeFormatId' => Yii::t('app', 'Time Format ID'),
        ];
    }
}
