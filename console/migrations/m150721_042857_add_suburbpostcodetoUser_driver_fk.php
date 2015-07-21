<?php

use yii\db\Schema;
use yii\db\Migration;

class m150721_042857_add_suburbpostcodetoUser_driver_fk extends Migration
{
    public function up()
    {

    }

    public function down()
    {
    }
    
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
       $this->addForeignKey('userdriver_stateId', 'userDriver', 'stateId', 'State', 'id');
    }
    
    public function safeDown()
    {
        $this->dropForeignKey('userdriver_stateId', 'userDriver');
    }
}
