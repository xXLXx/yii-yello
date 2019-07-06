<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "statementshiftitem".
 *
 * @property integer $idstatementshiftitem
 * @property integer $fkstatement
 * @property integer $fkshifthasdriverid
 * @property string $driverabn
 * @property integer $drivercompany
 * @property integer $drivergstamount
 * @property integer $driveramount
 */
class Statementshiftitem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'statementshiftitem';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fkstatement', 'fkshifthasdriverid', 'drivercompany', 'drivergstamount', 'driveramount'], 'integer'],
            [['driverabn'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idstatementshiftitem' => Yii::t('app', 'Idstatementshiftitem'),
            'fkstatement' => Yii::t('app', 'Fkstatement'),
            'fkshifthasdriverid' => Yii::t('app', 'Fkshifthasdriverid'),
            'driverabn' => Yii::t('app', 'Driverabn'),
            'drivercompany' => Yii::t('app', 'Drivercompany'),
            'drivergstamount' => Yii::t('app', 'Drivergstamount'),
            'driveramount' => Yii::t('app', 'Driveramount'),
        ];
    }
}
