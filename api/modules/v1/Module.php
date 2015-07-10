<?php
/**
 * REST API v1 module
 */

namespace api\modules\v1;

use api\modules\v1\models\User;

class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'api\modules\v1\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        \Yii::$app->user->identityClass = User::className();
    }
}