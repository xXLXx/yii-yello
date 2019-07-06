<?php

namespace frontend\controllers;

use common\services\ShiftCopyService;

use yii\web\Response;

/**
 * ShiftWeeklyCopyController
 *
 * @author markov
 */
class ShiftWeeklyCopyController extends BaseController
{
    public function actionIndex()
    {
        $request = \Yii::$app->getRequest();
        if ($request->getIsPost()) {
            ShiftCopyService::copy([
                'storeId' => $request->post('storeId'),
                'start'   => $request->post('start'),
                'end'     => $request->post('end'),
                'period'  => 'P7D',
                'assign'  => $request->post('assign') == 'yes',
            ]);
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'status' => 'ok'
            ];
        }

        return $this->renderPartial('index');
    }

    /**
     * Confirms a copied roster.
     *
     * @return array
     */
    public function actionConfirm()
    {
        $request = \Yii::$app->getRequest();
        $result = ShiftCopyService::confirm([
            'storeId' => $request->post('storeId'),
            'start'   => $request->post('start'),
            'end'     => $request->post('end'),
        ]);
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'result' => $result
        ];
    }

    /**
     * Cancels confirmation.
     *
     * @return array
     */
    public function actionCancelConfirm()
    {
        $request = \Yii::$app->getRequest();
        $result = ShiftCopyService::cancel([
            'storeId' => $request->post('storeId'),
            'start'   => $request->post('start'),
            'end'     => $request->post('end'),
        ]);
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'result' => $result
        ];
    }
}
