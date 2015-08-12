<?php

namespace api\modules\v1\controllers;

use Yii;
use api\modules\v1\filters\Auth;
use api\modules\v1\models\ShiftRequestReview;
use api\modules\v1\models\Shift;
use yii\web\BadRequestHttpException;


class RequestReviewController extends \api\common\controllers\RequestReviewController
{
    /**
     * @inheritdoc
     */
    public $modelClass = 'api\modules\v1\models\ShiftRequestReview';

    /**
     * @inheritdoc
     */
    protected function verbs()
    {
        return [
            'resubmit-deliveries' => ['POST'],
        ];
    }

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

    public function actionResubmitDeliveries()
    {
        $request = Yii::$app->request;
        
        $deliveryCount = (int)$request->post('deliveryCount', 0);
        $shiftId = (int)$request->post('shiftId', 0);
        $comment = $request->post('comment','no comment');
        if ( $deliveryCount && $shiftId ) {

            $requestReview = new ShiftRequestReview();
            $requestReview->shiftId = $shiftId;
            $requestReview->deliveryCount = $deliveryCount;
            $requestReview->userId = Yii::$app->user->identity->id;
            $requestReview->title = 'Driver Response';
            $requestReview->text = $comment;
            $requestReview->save();
            // also need to change the driver's delivery sumission amount

            return Shift::findOne($shiftId);
        }

        throw new BadRequestHttpException();
    }

}