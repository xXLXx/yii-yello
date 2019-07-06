<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SuperAdmin".
 *
 * @property integer $id
 * @property integer $yelloCompanyId
 */
class SuperAdmin extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'SuperAdmin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['yelloCompanyId'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'yelloCompanyId' => Yii::t('app', 'Yello Company ID'),
        ];
    }
}
