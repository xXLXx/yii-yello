<?php

use yii\db\Schema;
use yii\db\Migration;

class m150609_034412_UserDriverAccountNumberToStr extends Migration
{
    public function up()
    {
        $this->alterColumn('UserDriver', 'accountNumber', Schema::TYPE_STRING);
    }

    public function down()
    {
        $this->alterColumn('UserDriver', 'accountNumber', Schema::TYPE_INTEGER);
    }
}
