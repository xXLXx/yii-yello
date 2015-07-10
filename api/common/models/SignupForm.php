<?php
/**
 * Restful signup form model
 */

namespace api\common\models;


use common\models\Role;

class SignupForm extends \frontend\models\SignupForm
{
    /**
     * @inheritdoc
     */
    protected $_rolesAvailable = [
        Role::ROLE_DRIVER,
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        /** @var Role $role */
        $role = Role::findOne(['name' => Role::ROLE_DRIVER]);
        $this->roleId = $role->id;
    }

    /**
     * @inheritdoc
     */
    public function load($data, $formName = null)
    {
        $this->setAttributes($data);
        return true;
    }
}