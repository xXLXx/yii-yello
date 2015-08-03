<?php

namespace frontend\controllers;
use frontend\models\SignupInvitationsForm;
use Yii;
use yii\helpers\Html;
use api\common\models\Driver;
use frontend\models\StoreInviteDriverForm;

/**
 * Store invite driver controller
 *
 * @author markov
 */
class StoreInviteDriverController extends BaseController
{
    /**
     * Send invite
     */
    public function actionIndex()
    {
        $this->layout = 'empty';
        $storeInviteDriverForm = new StoreInviteDriverForm();
        $params = \Yii::$app->request->post();
        if ($storeInviteDriverForm->load($params)) {

            $driver_id = $params['StoreInviteDriverForm']['driverId'];

            if(!$driver_id && filter_var($params['invite_driver_input'], FILTER_VALIDATE_EMAIL) !== false){
                $invite_email =  $params['StoreInviteDriverForm']['email'] = $params['invite_driver_input'];
                $this->invite_driver($invite_email);
                return $this->render('success', [
                    'username' => $invite_email
                ]);
            }

            if ($storeInviteDriverForm->validate()) {
                $storeInviteDriverForm->save();
                $driver_data = Driver::findOne($driver_id);
                return $this->render('success', [
                    'username' => $driver_data['username']
                ]);
            }
        } else {
            $driverHasStoreId = \Yii::$app->request->post('id');
            $storeInviteDriverForm->setData($driverHasStoreId);
        }
        
        return $this->render('index', [
            'storeInviteDriverForm' => $storeInviteDriverForm
        ]);
    }

    function invite_driver($invite_email){

        $invitation_code = Yii::$app->security->generateRandomString();
        $user = \Yii::$app->user->identity;
        $storeTitle = $user->storeOwner->storeCurrent->title;
        /*$storeId = $user->storeOwner->storeCurrent->id;

        $signupinvitations = array("SignupInvitationsForm" =>
            array(
                'emailaddress' => $invite_email,
                'invitationcode' => $invitation_code,
                'userfk' => $user->id,
                'storeownerfk' => $storeId,
                //'datecreated' => NULL,
                //'dateupdated' => NULL,
                //'expires' => NULL,
                //'sent' => NULL,
                //'isArchived' => NULL,
                //'isRead' => NULL,
                //'isSignedUp' => NULL
            )
        );

        $signupInvitations = new SignupInvitationsForm();
        if($signupInvitations->load($signupinvitations)){
            if($signupInvitations->validate()){
                $signupInvitations->save($signupinvitations);
            };
        };*/


        $body = "You have been invited to be be a driver on Yello for $storeTitle and address. Click the link below to sign up to join Yello and connect to $storeTitle."
            . Html::a(
                'Sign up',
                Yii::$app->urlManager->createAbsoluteUrl(
                    [
                        'site/signup',
                        'invitationcode'  => $invitation_code
                    ]
                ),
                ['target' => '_blank']
            );
        $email = Yii::$app->mailer->compose()
            ->setTo($invite_email)
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setSubject('Yello Driver Invitation')
            ->setHtmlBody($body)
            ->send();
    }
}
