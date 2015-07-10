<?php

namespace common\services;

/**
 * User form service
 *
 * @author markov
 */
class UserFormService extends BaseService
{
    /**
     * Get form
     * 
     * @param string $name name
     * @return \frontend\models\UserForm\AbstractForm
     */
    public static function getForm($name)
    {
        $classForm = 'frontend\\models\\UserForm\\' . ucfirst($name) .
            'Form';
        $modelForm = new $classForm;
        return $modelForm;
    }
}
