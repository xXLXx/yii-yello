<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "message".
 *
 * @property integer $idmessage
 * @property integer $idrecipuser
 * @property string $origin
 * @property string $messagetype
 * @property string $messagetext
 * @property string $messagejson
 * @property integer $createdUTC
 * @property integer $sentUTC
 * @property string $sentVia
 * @property string $calltoaction
 * @property integer $expiresUTC
 * @property integer $received
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['createdUTC'],
                ],
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idrecipuser', 'createdUTC', 'sentUTC', 'expiresUTC', 'received'], 'integer'],
            [['origin'], 'string', 'max' => 255],
            [['messagetype', 'sentVia'], 'string', 'max' => 45],
            [['messagetext'], 'string', 'max' => 1500],
            [['messagejson'], 'string', 'max' => 2000],
            [['calltoaction'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idmessage' => Yii::t('app', 'Idmessage'),
            'idrecipuser' => Yii::t('app', 'Idrecipuser'),
            'origin' => Yii::t('app', 'Origin'),
            'messagetype' => Yii::t('app', 'Messagetype'),
            'messagetext' => Yii::t('app', 'Messagetext'),
            'messagejson' => Yii::t('app', 'Messagejson'),
            'createdUTC' => Yii::t('app', 'Created Utc'),
            'sentUTC' => Yii::t('app', 'Sent Utc'),
            'sentVia' => Yii::t('app', 'Sent Via'),
            'calltoaction' => Yii::t('app', 'Calltoaction'),
            'expiresUTC' => Yii::t('app', 'Expires Utc'),
            'received' => Yii::t('app', 'Received'),
        ];
    }
}
