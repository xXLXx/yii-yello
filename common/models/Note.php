<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "Note".
 *
 * @property integer $id
 * @property string $title
 */
class Note extends \common\models\BaseModel
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'drivernotes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [ ['note', 'driverId'], 'required']
        ];
    }
}
