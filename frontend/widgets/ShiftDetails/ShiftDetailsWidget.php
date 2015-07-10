<?php

namespace frontend\widgets\ShiftDetails;

use yii\base\Widget;
use common\models\Shift;

/**
 * Class ShiftDetailsWidget
 * @package frontend\widgets\ShiftDetails
 *
 * @author Yarovikov
 */
class ShiftDetailsWidget extends Widget
{

    public $shift;

    public function run()
    {
        if ( $this->shift instanceof Shift ) {

            $shiftState = $this->shift->shiftState;

            return $this->render('shiftDetails', [
                'shift' => $this->shift,
                'shiftState' => $shiftState,
            ]);
        }

        return '';
    }

}