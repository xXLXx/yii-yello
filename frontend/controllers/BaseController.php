<?php

namespace frontend\controllers;

use yii\web\Controller;

/**
 * Base controller
 *
 * @author markov
 */
class BaseController extends Controller 
{
 public function beforeAction($action) {

        if (parent::beforeAction($action)) {
            
                
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
