<?php

use yii\db\Schema;
use yii\db\Migration;

class m150526_081235_ShiftHasDriverRenameField extends Migration
{
    public function up()
    {
        $this->renameColumn('ShiftHasDriver', 'userId', 'driverId');
    }

    public function down()
    {
        $this->renameColumn('ShiftHasDriver', 'driverId', 'userId');
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
