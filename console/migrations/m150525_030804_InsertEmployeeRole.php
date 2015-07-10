<?php

use yii\db\Schema;
use common\models\Role;
use yii\db\Migration;

class m150525_030804_InsertEmployeeRole extends Migration
{
    public function up()
    {
        $this->insert('Role', ['name' => 'employee', 'title' => 'Employee']);
    }

    public function down()
    {
        $this->delete('Role', ['name' => 'employee']);
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
