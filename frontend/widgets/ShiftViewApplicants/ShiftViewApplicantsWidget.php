<?php

namespace frontend\widgets\ShiftViewApplicants;

use yii\base\Widget;
use common\models\Shift;

/**
 * Shift view applicants widget
 *
 * @author markov
 */
class ShiftViewApplicantsWidget extends Widget 
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
        $applicants = $shift->applicants;
        if (!$applicants) {
            return null;
        }
        return $this->render('default', [
            'applicants' => $applicants,
            'shift'      => $shift
        ]);
    }
}
