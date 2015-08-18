<?php

namespace frontend\widgets\ShiftForm;

use frontend\models\ShiftForm;
use common\models\Shift;
use yii\web\NotAcceptableHttpException;
use yii\helpers\Url;
use frontend\widgets\ShiftView\ShiftViewWidget;

/**
 * Shift form widget
 *
 * @author markov
 */
class ShiftFormWidget extends \yii\base\Widget
{
    /**
     * Shift id
     * 
     * @var integer
     */
    public $shiftId;
    
    /**
     * Store id
     * 
     * @var integer
     */
    public $storeId;
    
    
    /**
     * @inheritdoc
     */
    public function run()
    {
        $post = \Yii::$app->request->post();
        $shiftForm = new ShiftForm();
        if ($shiftForm->load($post)) {
            if ($shiftForm->validate()) {
                $shift = $shiftForm->save();
                $url = Url::to([
                    'shifts-calendar/shift-view', 'shiftId' => $shift->id
                ]);
                \Yii::$app->response->getHeaders()->set('X-PJAX', $url);
                return ShiftViewWidget::widget([
                    'shiftId' => $shift->id
                ]);
            } 
        } else {
            $shiftForm->storeId = $this->storeId;
            $shiftForm->isMyDrivers = true;
        }
        if ($this->shiftId) {
            $shift = Shift::findOne($this->shiftId);
            if ($shift) {
                if (!$shift->isEditable()) {
                    throw new NotAcceptableHttpException();
                }
                $shiftForm->setData($shift);
            }
        }else{
            
        }
        return $this->render('default', [
            'model' => $shiftForm
        ]); 
    }
}
