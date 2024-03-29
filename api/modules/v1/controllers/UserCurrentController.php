<?php
/**
 * v1-specific restful User current controller
 */
namespace api\modules\v1\controllers;

use api\modules\v1\filters\Auth;
use api\modules\v1\models\Driver;
use api\modules\v1\models\PasswordChangeForm;

class UserCurrentController extends \api\common\controllers\UserCurrentController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => Auth::className(),
        ];
        return $behaviors;
    }

    

    
    
    /**
     * Change password
     *
     * @return PasswordChangeForm|\common\models\User|null
     */
    public function actionChangePassword()
    {
        $form = new PasswordChangeForm();
        if ($form->load(\Yii::$app->request->post()) && $form->validate()) {
            $form->save();
            return Driver::getCurrent();
        }
        return $form;
    }

    /**
     * @return null|\yii\web\IdentityInterface
     */
    public function actionInfo()
    {
        return Driver::getCurrent();
    }

    /**
     * Switch Driver's 'isAvailableToWork' field to On or Off
     *
     * @param integer $on
     * @return Driver Currently authorized Driver model
     */
    public function actionAvailable()
    {
        $on = \Yii::$app->request->post('on');
        $driver = Driver::getCurrent();
        $userDriver = $driver->userDriver;
        $userDriver->updateAttributes([
            'isAvailableToWork' => (int) $on,
        ]);
        return Driver::getCurrent();
    }

    /**
     * Switch Driver's notifications on or off
     *
     * @param integer $on
     * @return Driver Currently authorized Driver model
     */
    public function actionNotifications()
    {
        $on = \Yii::$app->request->post('on');
        $driver = Driver::getCurrent();
        $userDriver = $driver->userDriver;
        $userDriver->updateAttributes([
            'isAllowedToReceiveNotifications' => (int) $on,
        ]);
        return Driver::getCurrent();
    }
}