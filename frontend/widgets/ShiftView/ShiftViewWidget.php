<?php

namespace frontend\widgets\ShiftView;

use common\models\Shift;

/**
 * Shfit view widget
 *
 * @author markov
 */
class ShiftViewWidget extends \yii\base\Widget 
{   
    /**
     * Shift id
     *  
     * @var integer 
     */
    public $shiftId;
    
    /**
     * @inheritdoc
     */
    public function run()
    {
        $shift = Shift::findOne($this->shiftId);
        if (!$shift) {
            return null;
        }
        $shiftState = $shift->shiftState;
        if (!$shiftState) {
            return null;
        }
        return $this->render('layout', [
            'shift'     => $shift,
            'stateName' => $shiftState->name
        ]);
    }
}
