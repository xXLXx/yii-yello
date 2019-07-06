<?php

use yii\db\Schema;
use yii\db\Migration;

class m150506_042433_UserAddFieldRole extends Migration
{
    public function up()
    {
        $this->addColumn('User', 'roleId', Schema::TYPE_INTEGER);
    }

    public function down()
    {
        $this->dropColumn('User', 'roleId');
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
