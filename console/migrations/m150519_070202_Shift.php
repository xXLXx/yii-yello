<?php

use yii\db\Schema;
use yii\db\Migration;

class m150519_070202_Shift extends Migration
{
    public function up()
    {
        $this->addColumn('Shift', 'storeId', Schema::TYPE_INTEGER);
    }

    public function down()
    {
        $this->dropColumn('Shift', 'storeId');
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
