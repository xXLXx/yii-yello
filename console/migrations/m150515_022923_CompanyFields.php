<?php

use yii\db\Schema;
use yii\db\Migration;

class m150515_022923_CompanyFields extends Migration
{
    public function up()
    {
        $this->addColumn('Company', 'postcode', Schema::TYPE_STRING);
        $this->addColumn('Company', 'countryId', Schema::TYPE_INTEGER);
        $this->addColumn('Company', 'timeFormatId', Schema::TYPE_INTEGER);
        $this->addColumn('Company', 'timeZoneId', Schema::TYPE_INTEGER);
        $this->addColumn('Company', 'currencyId', Schema::TYPE_INTEGER);
        $this->addColumn('Company', 'accountName', Schema::TYPE_STRING);
        $this->alterColumn('Company', 'suburb', Schema::TYPE_STRING);
    }

    public function down()
    {
        $this->dropColumn('Company', 'postcode');
        $this->dropColumn('Company', 'countryId');
        $this->addColumn('Company', 'timeFormatId');
        $this->addColumn('Company', 'timeZoneId');
        $this->addColumn('Company', 'currencyId'); 
        $this->addColumn('Company', 'accountName');
        $this->alterColumn('Company', 'suburb', Schema::TYPE_BOOLEAN);
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
