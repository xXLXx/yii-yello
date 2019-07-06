<?php

use yii\db\Schema;
use yii\db\Migration;

class m150608_023938_ShiftStateRename extends Migration
{
    public function up()
    {
        $this->update(
            'ShiftState', 
            [
                'title' => 'Awaiting approval'
            ], 
            ['name' => 'approval']
        );
    }

    public function down()
    {
        $this->update(
            'ShiftState', 
            [
                'title' => 'Approval'
            ], 
            ['name' => 'approval']
        );
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
