<?php
/**
 * Created by PhpStorm.
 * User: alireza
 * Date: 17/09/15
 * Time: 12:01 PM
 */
namespace common\helpers;

use Mandrill;

class EmailHelper
{

    /**
     * Class for sending email using Mandrill SDK.
     */


    /**
     * Send the email to the user.
     *
     * @param $template String the template name of the mandrill templates.
     * @param $to Array/String. The receiver of the email. it should be a array with 'email' and 'name' of the receiver user. It can be just the email.
     * @param $params Array. The key value params for the template variables. like ['STNAME' => 'YelloStore'];
     *
     * @return array. The return result by the Mandrill.
     */

    public static function sendEmail($template, $to, $params)
    {

        $message = self::addRcptToMessage($to);

        $message = self::makeTheMessageArray($params, $to, $message);

        $mailer = new \Mandrill(\Yii::$app->params['mandrill-apikey']);
        $sent = $mailer->messages->sendTemplate($template,[],$message);
        return $sent;

    }

    /**
     * Add the variables to the provided array. The required key value Array for Mandrill's Template variables with Mandrill's format!.
     * @param $params Array. The key value params for the template variables. like ['STNAME' => 'YelloStore'];
     * @param $to Array/String. The receiver of the email. it should be a array with 'email' and 'name' of the receiver user. It can be just the email.
     * @param $message Array The returned message by the addRcptToMessage function.
     *
     *
     * @return array. The ready array.
     */

    private static function makeTheMessageArray($params, $to, $message)
    {
        $merge_vars = [];

        if(is_array($params)) {

            $vars = [];
            foreach ($params as $key => $p) {
                $newArray = [];
                $newArray['name'] = $key;
                $newArray['content'] = $p;

                $vars[] = $newArray;
            }

            if (is_array($to) && isset($to['email'])) {

                $merge_vars['rcpt'] = $to['email'];
            } elseif(is_string($to)) {

                $merge_vars['rcpt'] = $to;
            }

            $merge_vars['vars'] = $vars;
        }

        $message['merge_vars'] = array($merge_vars);
        return $message;

    }

    /**
     * Initial the required key value Array for Mandrill's Template variables with Mandrill's format!.
     * @param $to Array/String. The receiver of the email. it should be a array with 'email' and 'name' of the receiver user. It can be just the email.
     *
     * @return array. The ready array.
     */

    private static function addRcptToMessage($to)
    {
        $message = [];

        if(is_array($to) && isset($to['email']) && isset($to['name']))
        {
            $newArray = array($to);
            $message['to'] = $newArray;

            return $message;

        }elseif(is_string($to))
        {
            $newArray = [
                'email' => $to,
            ];
            $newArray = array($newArray);
            $message['to'] = $newArray;
            return $message;
        }
        return false;
    }

}