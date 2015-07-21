<?php

use yii\db\Schema;
use yii\db\Migration;

class m150721_042604_add_suburbpostcodetoUser_driver extends Migration
{
    public function up()
    {
        $this->addColumn('UserDriver', 'suburb', Schema::TYPE_STRING);
        $this->addColumn('UserDriver', 'postcode', Schema::TYPE_STRING);
        $this->addColumn('UserDriver', 'stateId', Schema::TYPE_INTEGER . ' DEFAULT 1');
    }

    public function down()
    {
        $this->dropColumn('UserDriver', 'suburb');
        $this->dropColumn('UserDriver', 'postcode');
        $this->dropColumn('UserDriver', 'stateId');

    }
    
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }
    */
}
