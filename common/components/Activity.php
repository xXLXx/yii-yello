<?php

namespace common\components;

use common\models\Activity as ActivityModel;

/**
 * Component activity
 *
 * @author markov
 */
class Activity extends \yii\base\Component
{
    /**
     * Create activity
     * 
     * @param array $params
     * @return ActivityModel activity
     */
    public function create($params)
    {
        $activity = new ActivityModel();
        $activity->userId = $params['userId'];
        $activity->name = $params['name'];
        $activity->save();
        if (isset($params['params'])) {
            $activity->setParams($params['params']);
        }
        return $activity;
    }
}
