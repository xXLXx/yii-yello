<?php

namespace frontend\controllers;

use common\models\Role;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Base controller
 *
 * @author pottie
 */
class BaseController extends Controller 
{

//    public function beforeAction($action)
//    {
//        if (defined('YII_DEBUG') && YII_DEBUG) {
//            \Yii::$app->assetManager->forceCopy = true;
//        }
//
//        if (parent::beforeAction($action)) {
//            	// this calls getSignUpState  to verify all necessary user info is there
//				// getSignupState returns array of action, controller, ispreferred
//                // or false
//				// if getsignupstate returns array, the routine below checks to see if the
//				// current controller/action is in the array and if not, will redirect to ispreferred array row
//				// exceptions are all 'error' actions
//
//                if (!\Yii::$app->user->isGuest) {
//                    $user = \Yii::$app->user->identity;
//                    $loginurl = $user->getSignUpState();
//                    if($loginurl){
//                        if($action->id!='error'){
//                            $go=true;
//                            $goto = ($loginurl[0][0].'/'.$loginurl[0][1]);
//                            foreach ($loginurl as $ca){
//                                if($ca[0]==$action->controller->id && $ca[1]==$action->id){
//                                    $go=false; // do not redirect because user is allowed to visit this page
//                                }
//                                if($ca[2]==true){
//                                    $goto=($ca[0].'/'.$ca[1]);  // specified next redirect
//                                }
//                            }
//                            if($go){
//                                return \Yii::$app->getResponse()->redirect([$goto]);
//                            }
//                        }
//                    }
//                }
//                return true;
//           } else {
//               return false;
//           }
//
//    }

    public static $signup_steps_routes = [
        'driver' => [
            '1' => '/driver-signup/index',
            '2' => '/driver-signup/vehicle-info',
            '3' => '/driver-signup/work-info',
        ],
        'storeOwner' => [
            '1' => '/store-signup/index',
            '2' => '/store-signup/step-two',
            '3' => '/store-signup/step-three',
        ]
    ];

    /**
     * Check user signup completeness. Redirect to appropriate signup page.
     * 
     * @return array
     * 
     * JOVANI: this function should still allow users to visit certain other pages, and should also allow for error pages
     * See the function above - allows for error pages and array of allowed pages. does not redirect if request matches any
     * Please either change function below, or change to function above and corresponding function in User
     * Thankx :)
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => false,
                        'matchCallback' => function ($rule, $action) {
                            $user = \Yii::$app->user->identity;
                            $role = $user->role;

                            // Deny access if user is driver and driver signup not yet completed
                            // but exclude processing if route is intended signup page.
                            $currentRoute = '/' . $this->id . '/' . $action->id;
                            if ($role->name == Role::ROLE_DRIVER && $user->signup_step_completed < \Yii::$app->params['driver.signup_completion_step']
                                    && $currentRoute !== self::$signup_steps_routes[$role->name][$user->signup_step_completed + 1]) {
                                return true;
                            }

                            // Deny access if user is storeown and store signup not yet completed
                            // but exclude processing if route is intended signup page.
                            if ($role->name == Role::ROLE_STORE_OWNER && $user->signup_step_completed < \Yii::$app->params['storeOwner.signup_completion_step']
                                && $currentRoute !== self::$signup_steps_routes[$role->name][$user->signup_step_completed + 1]) {
                                return true;
                            }

                            return false;
                        }
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],

                'denyCallback' => function ($rule, $action) {
                    if (\Yii::$app->user->isGuest) {
                        \Yii::$app->user->loginRequired();
                    } else {
                        $user = \Yii::$app->user->identity;
                        $role = $user->role;
                        \Yii::$app->getResponse()->redirect(self::$signup_steps_routes[$role->name][$user->signup_step_completed + 1]);
                    }
                }
            ],
        ];
    }
}
