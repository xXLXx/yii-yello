<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sitesetting".
 *
 * @property integer $idsitesetting
 * @property string $settingname
 * @property string $settingfriendlyname
 * @property string $settingvalue
 * @property string $settingdefaultvalue
 * @property string $settingdescription
 * @property string $settingtype
 * @property string $settingoptions
 */
class Sitesetting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sitesetting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['settingname'], 'string', 'max' => 45],
            [['settingfriendlyname'], 'string', 'max' => 100],
            [['settingvalue', 'settingdefaultvalue'], 'string', 'max' => 500],
            [['settingdescription'], 'string', 'max' => 1500],
            [['settingtype'], 'string', 'max' => 15],
            [['settingoptions'], 'string', 'max' => 1000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idsitesetting' => Yii::t('app', 'Idsitesetting'),
            'settingname' => Yii::t('app', 'Settingname'),
            'settingfriendlyname' => Yii::t('app', 'Settingfriendlyname'),
            'settingvalue' => Yii::t('app', 'Settingvalue'),
            'settingdefaultvalue' => Yii::t('app', 'Settingdefaultvalue'),
            'settingdescription' => Yii::t('app', 'Settingdescription'),
            'settingtype' => Yii::t('app', 'Settingtype'),
            'settingoptions' => Yii::t('app', 'Settingoptions'),
        ];
    }
}
