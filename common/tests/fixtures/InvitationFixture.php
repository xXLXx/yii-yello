<?php
/**
 * Created by PhpStorm.
 * User: KustovVA
 * Date: 26.06.2015
 * Time: 13:45
 */

namespace common\tests\fixtures;


use yii\test\ActiveFixture;

class InvitationFixture extends ActiveFixture
{
    public $modelClass = 'common\models\Invitation';
    public $dataFile = '@common/tests/fixtures/data/Invitation.php';
}