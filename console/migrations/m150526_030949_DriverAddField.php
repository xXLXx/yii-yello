<?php

use yii\db\Schema;
use yii\db\Migration;

class m150526_030949_DriverAddField extends Migration
{
    public function up()
    {
        $this->addColumn('Driver', 'userId', Schema::TYPE_INTEGER);
    }

    public function down()
    {
        $this->dropColumn('Driver', 'userId');
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
