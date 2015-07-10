<?php

use yii\db\Schema;
use yii\db\Migration;

class m150525_081723_UserAddColumnAccessToken extends Migration
{
    public function up()
    {
        $this->addColumn('User', 'accessToken', Schema::TYPE_STRING . " NOT NULL AFTER `username`");
    }

    public function down()
    {
        $this->dropColumn('User', 'accessToken');
    }
}
