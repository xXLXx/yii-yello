<?php
/**
 * Custom fixture controller
 *
 * @author markov
 */

namespace console\controllers;


class FixtureController extends \yii\faker\FixtureController
{
    public $namespace = 'common\tests\fixtures';
    public $templatePath = '@common/tests/fixtures/templates';
    public $fixtureDataPath = '@common/tests/fixtures/data';

    public function actionLoad()
    {
        /**
         * For performance
         */
        $transaction  = \Yii::$app->db->beginTransaction();
        $ret = call_user_func_array('parent::actionLoad', func_get_args());
        $transaction->commit();

        return $ret;
    }
}