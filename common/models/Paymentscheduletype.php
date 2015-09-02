<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "paymentscheduletype".
 *
 * @property integer $idpaymentscheduletype
 * @property string $schedulename
 * @property string $reconcileper
 * @property integer $reconcileyellominimum
 * @property integer $staffperdelivery
 * @property integer $yelloperdelivery
 * @property integer $ondemandperdelivery
 * @property integer $driverperdelivery
 * @property integer $invoicefrequencydays
 * @property integer $invoiceweekdaysonly
 * @property string $description
 */
class Paymentscheduletype extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'paymentscheduletype';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reconcileyellominimum', 'staffperdelivery', 'yelloperdelivery', 'ondemandperdelivery', 'driverperdelivery', 'invoicefrequencydays', 'invoiceweekdaysonly'], 'integer'],
            [['schedulename'], 'string', 'max' => 450],
            [['reconcileper'], 'string', 'max' => 45],
            [['description'], 'string', 'max' => 1000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idpaymentscheduletype' => Yii::t('app', 'Idpaymentscheduletype'),
            'schedulename' => Yii::t('app', 'Schedulename'),
            'reconcileper' => Yii::t('app', 'Reconcileper'),
            'reconcileyellominimum' => Yii::t('app', 'Reconcileyellominimum'),
            'staffperdelivery' => Yii::t('app', 'Staffperdelivery'),
            'yelloperdelivery' => Yii::t('app', 'Yelloperdelivery'),
            'ondemandperdelivery' => Yii::t('app', 'Ondemandperdelivery'),
            'driverperdelivery' => Yii::t('app', 'Driverperdelivery'),
            'invoicefrequencydays' => Yii::t('app', 'Invoicefrequencydays'),
            'invoiceweekdaysonly' => Yii::t('app', 'Invoiceweekdaysonly'),
            'description' => Yii::t('app', 'Description'),
        ];
    }
}
