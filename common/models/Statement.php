<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "statement".
 *
 * @property integer $idstatement
 * @property integer $fkpaymentschedule
 * @property integer $fkcompany
 * @property integer $fkstore
 * @property string $attention
 */
class Statement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'statement';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fkpaymentschedule', 'fkcompany', 'fkstore'], 'integer'],
            [['attention'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idstatement' => Yii::t('app', 'Idstatement'),
            'fkpaymentschedule' => Yii::t('app', 'Fkpaymentschedule'),
            'fkcompany' => Yii::t('app', 'Fkcompany'),
            'fkstore' => Yii::t('app', 'Fkstore'),
            'attention' => Yii::t('app', 'Attention'),
        ];
    }
}
