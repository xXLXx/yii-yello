<?php

namespace frontend\controllers;

use common\services\ShiftCopyService;

/**
 * ShiftWeeklyCopyController
 *
 * @author markov
 */
class ShiftWeeklyCopyController extends BaseController
{
    /**
     * Copy weekly sheet
     */
    public function actionCopy()
    {
        $post = \Yii::$app->request->post();
        $user = \Yii::$app->user->identity;
        $storeId = $user->storeCurrent->id;
        ShiftCopyService::copy([
            'storeId' => $storeId,
            'start'   => $post['start'],
            'end'     => $post['end'],
            'period'  => 'P7D'
        ]);
    }
}
