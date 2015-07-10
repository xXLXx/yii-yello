<?php

namespace frontend\widgets\ShiftStatesCount;

use common\models\ShiftState;

/**
 * Shift states count widget
 *
 * @author markov
 */
class ShiftStatesCountWidget extends \yii\base\Widget
{
    /**
     * @inheritdoc
     */
    public function run()
    {
        $states = ShiftState::find()->all();
        return $this->render('default', [
            'states' => $states
        ]);
    }
}
