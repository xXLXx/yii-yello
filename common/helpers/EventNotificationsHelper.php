<?php

namespace common\helpers;

use Pubnub\Pubnub;
use common\models\Shift;
use common\models\Store;
use common\helpers\MessageHelper;

/**
 * Class for sending in event notifications type messages
 */
class EventNotificationsHelper extends MessageHelper
{
    const NOTIFTTYPE_SHIFTAPPROVED = 'SHIFT_APPROVED';
    const NOTIFTTYPE_SHIFTDECLINED = 'SHIFT_DECLINED';
    const NOTIFTTYPE_PAYMENTPROCESSED = 'PAYMENT_PROCESSED';
    const NOTIFTTYPE_SHIFTDISPUTED = 'SHIFT_DISPUTED';
    const NOTIFTTYPE_SHIFTALLOCATED = 'SHIFT_ALLOCATED';
    const NOTIFTTYPE_SHIFTCANCELLED = 'SHIFT_CANCELLED';

    const NOTIFTTYPE_STOREINVITATION = 'STORE_INVITATION';
    const NOTIFTTYPE_STOREDISCONNECTED = 'STORE_DISCONNECTED';

	private static $channelPrefix = 'notifications_';

    /**
     * Notify shift has been approved
     *
     * @param $driverId int driver's id used to pusblish notification to.
     * @param $shiftId int shift id the driver has been approved to.
     */
    public static function approveShift($driverId, $shiftId)
    {
        $shift = Shift::find()->innerJoinWith('store')->where([Shift::tableName() . '.id' => $shiftId])->one();

        if (!$shift) {
            return;
        }

        self::publishMessage(
            $driverId,
            ['shift_id' => "$shiftId"],
            self::NOTIFTTYPE_SHIFTAPPROVED,
            $shift->store->title . ' has approved your application. ' . $shift->start
        );
    }

    /**
     * Notify shift has been declined
     *
     * @param $driverId int driver's id used to pusblish notification to.
     * @param $shiftId int shift id the driver has been declined to.
     */
    public static function declineShift($driverId, $shiftId)
    {
        $shift = Shift::find()->innerJoinWith('store')->where([Shift::tableName() . '.id' => $shiftId])->one();

        if (!$shift) {
            return;
        }

        self::publishMessage(
            $driverId,
            ['shift_id' => "$shiftId"],
            self::NOTIFTTYPE_SHIFTDECLINED,
            'Sorry,' . $shift->store->title . ' Has awarded this application to another driver :(' . $shift->start
        );
    }

    /**
     * Notify shift payment hs been processed
     *
     * @param $driverId int driver's id used to pusblish notification to.
     * @param $shiftId int shift id the payment is processed.
     */
    public static function processShiftPayment($driverId, $shiftId)
    {
        $shift = Shift::find()->innerJoinWith('store')->where([Shift::tableName() . '.id' => $shiftId])->one();

        if (!$shift) {
            return;
        }

        self::publishMessage(
            $driverId,
            ['shift_id' => "$shiftId"],
            self::NOTIFTTYPE_PAYMENTPROCESSED,
            $shift->store->title . ' has processed your payment. ' . \Yii::$app->formatter->asCurrency($shift->payment)
        );
    }

    /**
     * Notify shift has been disputed
     *
     * @param $driverId int driver's id used to pusblish notification to.
     * @param $shiftId int shift id the driver has been disputed to.
     */
    public static function disputeShift($driverId, $shiftId)
    {
        $shift = Shift::find()->innerJoinWith('store')->where([Shift::tableName() . '.id' => $shiftId])->one();

        if (!$shift) {
            return;
        }

        self::publishMessage(
            $driverId,
            ['shift_id' => "$shiftId"],
            self::NOTIFTTYPE_SHIFTDISPUTED,
            $shift->store->title . ' has disputed your delivery number. Changed from ' .
                $shift->deliveryCount . ' to ' . $shift->lastStoreOwnerShiftRequestReview->deliveryCount
        );
    }

    /**
     * Notify shift has been allocated
     *
     * @param $driverId int driver's id used to pusblish notification to.
     * @param $shiftId int shift id the driver has been allocated to.
     */
    public static function allocateShift($driverId, $shiftId)
    {
        $shift = Shift::find()->innerJoinWith('store')->where([Shift::tableName() . '.id' => $shiftId])->one();

        if (!$shift) {
            return;
        }

        self::publishMessage(
            $driverId,
            ['shift_id' => "$shiftId"],
            self::NOTIFTTYPE_SHIFTALLOCATED,
            $shift->store->title . ' has assigned you a shift. ' . $shift->start
        );
    }

    /**
     * Notify shift has been cancelled
     *
     * @param $driverId int driver's id used to pusblish notification to.
     * @param $shiftId int shift id the driver has been cancelled to.
     */
    public static function cancelShift($driverId, $shiftId)
    {
        $shift = Shift::find()->innerJoinWith('store')->where([Shift::tableName() . '.id' => $shiftId])->one();

        if (!$shift) {
            return;
        }

        self::publishMessage(
            $driverId,
            ['shift_id' => "$shiftId"],
            self::NOTIFTTYPE_SHIFTCANCELLED,
            $shift->store->title . ' has cancelled your shift :( ' . $shift->start
        );
    }

    /**
     * Notify shift has expired
     *
     * @param $driverId int driver's id used to pusblish notification to.
     * @param $shiftId int shift id the driver has been cancelled to.
     */
    public static function expireShift($driverId, $shiftId)
    {
        $shift = Shift::find()->innerJoinWith('store')->where([Shift::tableName() . '.id' => $shiftId])->one();

        if (!$shift) {
            return;
        }

        self::publishMessage(
            $driverId,
            ['shift_id' => "$shiftId"],
            self::NOTIFTTYPE_SHIFTCANCELLED,
            'Your shift for ' . $shift->store->title . ' has expired :( ' . $shift->start
        );
    }

    /**
     * Notify that a store invitation is received
     *
     * @param $driverId int driver's id used to pusblish notification to.
     * @param $storeId int store that sent invitation
     */
    public static function storeInvite($driverId, $storeId)
    {
        $store = Store::find()->where([Store::tableName() . '.id' => $storeId])->one();

        if (!$store) {
            return;
        }

        self::publishMessage(
            $driverId,
            ['store_id' => "$storeId"],
            self::NOTIFTTYPE_STOREINVITATION,
            $store->title . ' has invited you to connect'
        );
    }

    /**
     * Notify that a store has disconnected to driver
     *
     * @param $driverId int driver's id used to pusblish notification to.
     * @param $storeId int store that driver is removed from
     */
    public static function storeDisconnect($driverId, $storeId)
    {
        $store = Store::find()->where([Store::tableName() . '.id' => $storeId])->one();

        if (!$store) {
            return;
        }

        self::publishMessage(
            $driverId,
            ['store_id' => "$storeId"],
            self::NOTIFTTYPE_STOREDISCONNECTED,
            $store->title . ' has removed you from their store :('
        );
    }

    /**
     * Publishes standard PN message event notification as per spec
     *
     * @param $channelPostfix string the postfix to append to PN channel, usually driver's id
     * @param $extraAttrs object attributes to send with PN message
     * @param $notificationType string value from self::NOTIFTTYPE_*
     * @param $alert string the alert for notification
     */
    private static function publishMessage($channelPostfix, $extraAttrs, $notificationType, $alert)
    {
    	$pubnub = new Pubnub([
			'subscribe_key' => \Yii::$app->params['pubnubSubscribeKey'],
            'publish_key' => \Yii::$app->params['pubnubPublishKey'],
			'uuid' => 'event_notifier',
		]);

    	$message = [
    		'notification_type' => $notificationType,
    		'pn_apns' => [
    			'aps' => [
                    'alert'                 => $alert,
    				'notification_type'     => $notificationType,
                    'badge'                 => 1,
                    'sound'                 => 'bingbong.aiff'
    			] + $extraAttrs
    		]
    	] + $extraAttrs;

		$info = $pubnub->publish(self::$channelPrefix . $channelPostfix, $message);

        $messageSentUTC = null;

        if(!empty($info) && isset($info[1]) && isset($info[2])){

            if($info[1] == 'Sent'){
                $messageSentUTC = substr($info[2],0,10);
            }
        }

        $messageType = self::MESSAGETYPE_SHIFTNOTIF;
        switch ($notificationType) {
            case self::NOTIFTTYPE_STOREINVITATION:
            case self::NOTIFTTYPE_STOREDISCONNECTED:
                $messageType = self::MESSAGETYPE_STORENOTIF;
                break;
        }

        self::notifyUser($channelPostfix, $notificationType, self::SENTVIA_PUBNUB, 'None', 'System', $messageType, null, json_encode($message), 0, $messageSentUTC);
    }
}