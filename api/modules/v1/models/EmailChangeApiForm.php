<?php
/**
 * Created by PhpStorm.
 * User: alireza
 * Date: 10/09/15
 * Time: 3:42 PM
 */

namespace api\modules\v1\models;


use common\models\EmailChangeForm;

class EmailChangeApiForm extends EmailChangeForm
{

    public function load($data, $formName = null)
    {
        $this->setAttributes($data);
        return true;
    }

}