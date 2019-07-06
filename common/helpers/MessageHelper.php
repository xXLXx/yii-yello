<?php

namespace common\helpers;

use common\models\Message;

class MessageHelper
{
    const SENTVIA_PUBNUB = 'pubnub';
    const SENTVIA_EMAIL = 'email';
    const SENTVIA_SMS = 'sms';
    const SENTVIA_WEBAPP = 'webapp';

//    const MESSAGETYPE_SHIFTNOTIF = 'Shift Notification';
//    const MESSAGETYPE_STORENOTIF = 'Store Notification';
//    const MESSAGETYPE_CALLTOACTION = 'Call to Action';

    /*
     * The MESSAGETYPE_* is the type of the receiver of the message(Notification). It will go to messagetype column of the message
     * table, if it is 'driver', it means that the idrecipuser is the user id of the driver. If it is 'store', it means that the
     * idrecipuser is the Store id.
     *
     *
     * */
    const MESSAGETYPE_USER = 'user';
    const MESSAGETYPE_DRIVER = 'driver';
    const MESSAGETYPE_STORE = 'store';


    /*
     *  notifyUser
     * add a message to the central message table
     * $supercedes can nominate previous unsent messages to be cancelled.
     */
    
    public static function notifyUser($recipuserid, $messagetext, $sentVia, $calltoaction = 'None', $origin = 'System', $messagetype = 'Notice', $supercedes = null, $messagejson = '', $expiresUTC = 0, $sentUTC = null)
    {
    	$message = new Message();
    	$message->idrecipuser = $recipuserid;
    	$message->origin = $origin;
    	$message->messagetype = $messagetype;
    	$message->messagetext = $messagetext;
    	$message->messagejson = $messagejson;
    	$message->sentVia = $sentVia;
    	$message->calltoaction = $calltoaction;
    	$message->expiresUTC = $expiresUTC;
        $message->sentUTC = $sentUTC;
    	
    	return $message->save();
    }
}