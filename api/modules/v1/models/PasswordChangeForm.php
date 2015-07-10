<?php
/**
 * v1-specific Restful Password change form
 */

namespace api\modules\v1\models;


class PasswordChangeForm extends \common\models\PasswordChangeForm
{
    /**
     * @inheritdoc
     */
    public function load($data, $formName = null)
    {
        $this->setAttributes($data);
        return true;
    }
}