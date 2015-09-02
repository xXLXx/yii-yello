<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "paymentschedule".
 *
 * @property integer $idpaymentschedule
 * @property integer $paymentscheduletypefk
 * @property integer $storefk
 * @property integer $companyfk
 * @property string $reconcileper
 * @property integer $reconcileyellominimum
 * @property integer $staffperdelivery
 * @property integer $yelloperdelivery
 * @property integer $ondemandperdelivery
 * @property integer $driverperdelivery
 * @property integer $mindeliveryamount
 * @property integer $invoicefrequencydays
 * @property integer $invoicefrequencyweekdaysonly
 * @property integer $datecommenced
 * @property integer $datelastinvoice
 * @property string $stripefk
 */
class Paymentschedule extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'paymentschedule';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['paymentscheduletypefk', 'storefk', 'companyfk', 'reconcileyellominimum', 'staffperdelivery', 'yelloperdelivery', 'ondemandperdelivery', 'driverperdelivery', 'mindeliveryamount', 'invoicefrequencydays', 'invoicefrequencyweekdaysonly', 'datecommenced', 'datelastinvoice'], 'integer'],
            [['reconcileper'], 'string', 'max' => 45],
            [['stripefk'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idpaymentschedule' => Yii::t('app', 'Idpaymentschedule'),
            'paymentscheduletypefk' => Yii::t('app', 'Paymentscheduletypefk'),
            'storefk' => Yii::t('app', 'Storefk'),
            'companyfk' => Yii::t('app', 'Companyfk'),
            'reconcileper' => Yii::t('app', 'Reconcileper'),
            'reconcileyellominimum' => Yii::t('app', 'Reconcileyellominimum'),
            'staffperdelivery' => Yii::t('app', 'Staffperdelivery'),
            'yelloperdelivery' => Yii::t('app', 'Yelloperdelivery'),
            'ondemandperdelivery' => Yii::t('app', 'Ondemandperdelivery'),
            'driverperdelivery' => Yii::t('app', 'Driverperdelivery'),
            'mindeliveryamount' => Yii::t('app', 'Mindeliveryamount'),
            'invoicefrequencydays' => Yii::t('app', 'Invoicefrequencydays'),
            'invoicefrequencyweekdaysonly' => Yii::t('app', 'Invoicefrequencyweekdaysonly'),
            'datecommenced' => Yii::t('app', 'Datecommenced'),
            'datelastinvoice' => Yii::t('app', 'Datelastinvoice'),
            'stripefk' => Yii::t('app', 'Stripefk'),
        ];
    }
}
