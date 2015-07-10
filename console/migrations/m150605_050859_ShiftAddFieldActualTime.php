<?php

use yii\db\Schema;
use yii\db\Migration;

class m150605_050859_ShiftAddFieldActualTime extends Migration
{
    public function up()
    {
        $this->addColumn('Shift', 'actualStart', Schema::TYPE_DATETIME);
        $this->addColumn('Shift', 'actualEnd', Schema::TYPE_DATETIME);
    }

    public function down()
    {
        $this->dropColumn('Shift', 'actualStart');
        $this->dropColumn('Shift', 'actualEnd');
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
