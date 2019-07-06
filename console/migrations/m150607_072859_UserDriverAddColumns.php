<?php

use yii\db\Schema;
use yii\db\Migration;

class m150607_072859_UserDriverAddColumns extends Migration
{
    public function up()
    {
        $this->addColumn('UserDriver', 'address1', Schema::TYPE_STRING);
        $this->addColumn('UserDriver', 'address2', Schema::TYPE_STRING);
        $this->addColumn('UserDriver', 'companyName', Schema::TYPE_STRING);
        $this->addColumn('UserDriver', 'registeredForGst', Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT 1');
        $this->addColumn('UserDriver', 'abn', Schema::TYPE_STRING);
        $this->addColumn('UserDriver', 'bankName', Schema::TYPE_STRING);
        $this->addColumn('UserDriver', 'bsb', Schema::TYPE_STRING);
        $this->addColumn('UserDriver', 'accountNumber', Schema::TYPE_INTEGER);
    }

    public function down()
    {
        $this->dropColumn('UserDriver', 'address1');
        $this->dropColumn('UserDriver', 'address2');
        $this->dropColumn('UserDriver', 'companyName');
        $this->dropColumn('UserDriver', 'registeredForGst');
        $this->dropColumn('UserDriver', 'abn');
        $this->dropColumn('UserDriver', 'bankName');
        $this->dropColumn('UserDriver', 'bsb');
        $this->dropColumn('UserDriver', 'accountNumber');
    }
}
