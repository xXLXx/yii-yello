<?php

use yii\db\Schema;
use yii\db\Migration;

class m150604_013935_SHiftRelationState extends Migration
{
    public function up()
    {
        $this->addColumn('Shift', 'shiftStateId', Schema::TYPE_INTEGER);
    }

    public function down()
    {
        $this->dropColumn('Shift', 'shiftStateId');
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
