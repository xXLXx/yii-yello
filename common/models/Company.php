<?php

namespace common\models;

use common\helpers\ImageResizeHelper;
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

    /**
     * Get Address
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses()
    {
        return $this->hasMany(Address::className(), ['idaddress' => 'addressfk'])->
            viaTable('companyaddress', ['companyfk' => 'id']);
    }

    /**
     * Get CompanyAddress
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompanyAddress()
    {
        return $this->hasOne(CompanyAddress::className(), ['companyfk' => 'id']);
    }

    /**
     * Get Address
     *
     * @return \yii\db\ActiveRecord
     */
    public function getAddress()
    {
        return $this->hasOne(Address::className(), ['idaddress' => 'addressfk'])
            ->via('companyAddress');
    }

    /**
     * Get image
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'imageId']);
    }

    /**
     * The path pattern.
     *
     * @return string
     */
    public function getLogoPathPattern()
    {
        return '/companyfiles/{id}/logo.png';
    }

    /**
     * The path pattern.
     *
     * @return string
     */
    public function getLogoPath()
    {
        return str_replace('{id}', $this->id, $this->getLogoPathPattern());
    }

    /**
     * Upload logo.
     *
     * @todo thumb should be done in the background via a queuing system.
     * @param  string $sourceFile path to source file
     * @return mixed
     * @throws \Exception
     */
    public function uploadLogo($sourceFile)
    {
        $sizes = [
            'original' => $this->getLogoPath(),
        ];

        $result = ImageResizeHelper::resizeAndUpload($sourceFile, $sizes);

        if (empty($result)) {
            throw new \Exception('Upload failed.');
        }

        return $result['original'];
    }
}
