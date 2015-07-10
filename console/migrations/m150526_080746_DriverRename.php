<?php

use yii\db\Schema;
use yii\db\Migration;

class m150526_080746_DriverRename extends Migration
{
    public function up()
    {
        $this->renameTable('Driver', 'UserDriver');
    }

    public function down()
    {
        $this->renameTable('UserDriver', 'Driver');
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
