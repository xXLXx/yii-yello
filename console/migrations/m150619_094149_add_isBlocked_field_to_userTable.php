<?php

use yii\db\Schema;
use yii\db\Migration;

class m150619_094149_add_isBlocked_field_to_userTable extends Migration
{
    public function up()
    {
        $this->addColumn('User', 'isBlocked', 'tinyint(1)');
    }

    public function down()
    {
        $this->dropColumn('User', 'isBlocked');
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
