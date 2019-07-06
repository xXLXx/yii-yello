<?php

namespace frontend\widgets;

use yii\bootstrap\Nav;

class Navigation extends Nav
{
    /**
     * @inheritdoc
     */
    public function run()
    {
        $controllerId = \Yii::$app->controller->id;
        $actionId = \Yii::$app->controller->action->id;
        foreach ($this->items as &$item) {
            if (isset($item['heading'])) {
                continue;
            }else{
                if (!isset($item['url'])) {
                    continue;
                }
                if (!is_array($item['url'])) {
                    continue;
                }
                $parts = explode('/', $item['url'][0]);
                $item['active'] = $parts[0] == $controllerId && $parts[1] == $actionId;
            }
            
        }
        return parent::run();
    }
}