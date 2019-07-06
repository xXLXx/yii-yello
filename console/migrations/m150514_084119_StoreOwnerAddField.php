<?php

use yii\db\Schema;
use yii\db\Migration;

class m150514_084119_StoreOwnerAddField extends Migration
{
    public function up()
    {
        $this->addColumn('StoreOwner', 'userId', Schema::TYPE_INTEGER);
    }

    public function down()
    {
        $this->dropColumn('StoreOwner', 'userId');
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
