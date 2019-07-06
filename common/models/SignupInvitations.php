<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "SignupInvitations".
 *
 * @property integer $id;
 * @property integer userfk;
 * @property string emailaddress;
 * @property string invitationcode;
 * @property integer storeownerfk;
 * @property integer createdAt;
 * @property integer updatedAt;
 * @property integer expires;
 * @property integer sent;
 * @property integer isArchived;
 * @property integer isRead;
 * @property integer isSignedUp;
 */
class SignupInvitations extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'signupinvitations';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userfk', 'createdAt', 'updatedAt'], 'integer'],
            [['emailaddress', 'invitationcode', 'storeownerfk'], 'required'],
            [['expires', 'sent', 'isArchived', 'isRead', 'isSignedUp'], 'safe']

        ];
    }


}
