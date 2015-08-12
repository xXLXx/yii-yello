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
}
