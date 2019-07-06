<?php

use yii\db\Schema;
use yii\db\Migration;

class m150605_055023_UserDriverAddColumnIsArchived extends Migration
{
    public function up()
    {
        $this->addColumn('UserDriver', 'isArchived', Schema::TYPE_BOOLEAN . " DEFAULT 0");
    }

    public function down()
    {
        $this->dropColumn('UserDriver', 'isArchived');
    }
}
