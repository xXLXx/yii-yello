<?php

namespace frontend\models;

use common\models\SignupInvitations;
use yii\base\Model;

/**
 * Driver has store form
 *
 * @author lalit
 */
class SignupInvitationsForm extends Model
{
    public $id;
    public $userfk;
    public $emailaddress;
    public $invitationcode;
    public $storeownerfk;
    public $createdAt;
    public $updatedAt;
    public $expires;
    public $sent;
    public $isArchived;
    public $isRead;
    public $isSignedUp;

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
    

    
    /**
     * Save
     * 
     * @return Save Status
     */
    public function save()
    {
        $signUpInvitations = new SignupInvitations();
        $signUpInvitations->setAttributes($this->getAttributes());
        $save = $signUpInvitations->save();
        return $save;
    }
}
