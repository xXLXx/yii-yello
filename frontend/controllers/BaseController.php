<?php

namespace frontend\controllers;

use yii\web\Controller;

/**
 * Base controller
 *
 * @author pottie
 */
class BaseController extends Controller 
{
 public function beforeAction($action) {

        if (parent::beforeAction($action)) {
            	// this calls getSignUpState  to verify all necessary user info is there
				// getSignupState returns array of action, controller, ispreferred
                // or false
				// if getsignupstate returns array, the routine below checks to see if the 
				// current controller/action is in the array and if not, will redirect to ispreferred array row
				// exceptions are all 'error' actions
				
                if (!\Yii::$app->user->isGuest) {
                    $user = \Yii::$app->user->identity;
                    $loginurl = $user->getSignUpState();
                    if($loginurl){
                        if($action->id!='error'){
                            $go=true;
                            $goto = ($loginurl[0][0].'/'.$loginurl[0][1]);
                            foreach ($loginurl as $ca){
                                if($ca[0]==$action->controller->id && $ca[1]==$action->id){
                                    $go=false; // do not redirect because user is allowed to visit this page
                                }
                                if($ca[2]==true){
                                    $goto=($ca[0].'/'.$ca[1]);  // specified next redirect
                                }
                            }
                            if($go){
                                return \Yii::$app->getResponse()->redirect([$goto]);
                            }

                        }
                    }
                }            
                    return true;
           } else {
               return false;
           }     

    }    
}
