<?php

use yii\db\Schema;
use yii\db\Migration;

class m150520_080519_StoreAddCompanyId extends Migration
{
    public function up()
    {
        $this->addColumn('Store', 'companyId', Schema::TYPE_INTEGER);
    }

    public function down()
    {
        $this->dropColumn('Store', 'companyId');
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
