<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "storeaddress".
 *
 * @property integer $idstoreaddress
 * @property integer $storefk
 * @property integer $addressfk
 * @property integer $addresstype
 * @property string $addresstitle
 * @property string $contact_name
 * @property string $contact_phone
 * @property string $contact_email
 * @property integer $createdUTC
 * @property integer $updatedUTC
 * @property integer $isarchived
 */
class StoreAddress extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'storeaddress';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['storefk', 'addressfk'], 'required'],
            [['storefk', 'addressfk', 'addresstype', 'createdUTC', 'updatedUTC', 'isarchived'], 'integer'],
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
            'idstoreaddress' => Yii::t('app', 'Idstoreaddress'),
            'storefk' => Yii::t('app', 'Storefk'),
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
     * @TODO mark, should we instead make this as `createdAt` and `updatedAt` to be
     * consistent with the rest?
     *
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
}
