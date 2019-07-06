<?php

use yii\db\Schema;
use yii\db\Migration;

class m150520_070407_StoreDropCompanyId extends Migration
{
    public function up()
    {
        $this->dropColumn('Store', 'companyId');
    }

    public function down()
    {
        $this->addColumn('Store', 'companyId', Schema::TYPE_INTEGER);
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
