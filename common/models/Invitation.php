<?php
/**
 * Created by PhpStorm.
 * User: KustovVA
 * Date: 26.06.2015
 * Time: 12:18
 */

namespace common\models;
use common\behaviors\DatetimeFormatBehavior;
use yii\db\ActiveQuery;

/**
 * Class Invitation
 *
 * @Entity()
 * @Table(name="Invitation")
 * @SoftDeletable(field="isArchived")
 *
 * @property int $id id
 * @property string $name Name
 * @property string $email Email
 * @property InvitationStatus $status Invitation status
 * @property int $statusId status Id
 * @property integer $createdAt Created at
 * @property integer $updatedAt Updated at
 * @property bool $isArchived Deleted at
 * @property string $createdAtAsDateTime
 * @property string $updatedAtAsDateTime
 *
 * @package common\models
 */
class Invitation extends BaseModel
{
    public static function tableName()
    {
        return 'Invitation';
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors[] = [
            'class' => DatetimeFormatBehavior::className(),
            DatetimeFormatBehavior::ATTRIBUTES_TIMESTAMP => ['createdAt', 'updatedAt'],
        ];
        return $behaviors;
    }

    /**
     * @return ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(InvitationStatus::className(), ['id' => 'statusId']);
    }

}