<?php

namespace common\models;

use Yii;
use common\behaviors\DatetimeFormatBehavior;
use common\models\Role;
use common\models\Shift;

/**
 * This is the model class for table "ShiftRequestReview".
 *
 * @property integer $id
 * @property string $title
 * @property string $text
 * @property integer $deliveryCount
 * @property integer $shiftId
 * @property integer $userId
 * @property string $createdAtAsDatetime
 * @property string $updatedAtAsDatetime
 *
 * @property User $user
 */
class ShiftRequestReview extends BaseModel
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors[] = [
            'class' => DatetimeFormatBehavior::className(),
            DatetimeFormatBehavior::ATTRIBUTES_TIMESTAMP => ['createdAt', 'updatedAt'],
        ];
        return $behaviors;
    }

    public function fields()
    {
        return [
            'id',
            'title',
            'text',
            'shiftId',
            'deliveryCount',
            'createdAt' => 'createdAtAsTimestamp',
            'createdAtAsDatetime',
            'updatedAt' => 'updatedAtAsTimestamp',
            'updatedAtAsDatetime',
            'userId'
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ShiftRequestReview';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text'], 'string'],
            [['shiftId', 'userId', 'deliveryCount'], 'integer'],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'text' => Yii::t('app', 'Text'),
            'deliveryCount' => Yii::t('app', 'Delivery count'),
            'shiftId' => Yii::t('app', 'Shift ID'),
            'userId' => Yii::t('app', 'User ID'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $currentRole = Yii::$app->user->identity->role->name;

        /* @var $shift Shift */
        $shift = Shift::findOne(['id' => $this->shiftId]);

        if ( $currentRole === Role::ROLE_STORE_OWNER ) {

            $shift->setStateDisputed();

        } elseif ( $currentRole === Role::ROLE_DRIVER ) {

            $shift->setStateUnderReview();
        }
    }

    /**
     * get request review author
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }

}
