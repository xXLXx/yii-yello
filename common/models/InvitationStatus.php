<?php
/**
 * Created by PhpStorm.
 * User: KustovVA
 * Date: 26.06.2015
 * Time: 12:18
 */

namespace common\models;

/**
 * Class InvitationStatus
 *
 * @Entity()
 * @Table(name="InvitationStatus")
 *
 * @property int $id id
 * @property string $name name
 * @property integer $createdAt
 * @property integer $updatedAt
 * @property bool $isArchived
 *
 * @package common\models
 */
class InvitationStatus extends BaseModel
{
    const PENDING = 'Pending';
    const REGISTRATION = 'Registration';
    const CONNECTED = 'Connected';

    public static function tableName()
    {
        return 'InvitationStatus';
    }

}