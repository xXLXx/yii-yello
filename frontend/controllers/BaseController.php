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
                            foreach ($loginurl as $ca){
                                if($ca[0]==$action->controller->id && $ca[1]==$action->id){
                                    $go=false;
                                }
                            }
                            if($go){
                                return \Yii::$app->getResponse()->redirect([$loginurl[0][0].'/'.$loginurl[0][1]]);
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
