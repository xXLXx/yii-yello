<?php

use yii\db\Schema;
use yii\db\Migration;

class m150518_064352_StoreFields extends Migration
{
    public function up()
    {
        $this->addColumn('Store', 'address1', Schema::TYPE_STRING);
        $this->addColumn('Store', 'address2', Schema::TYPE_STRING);
        $this->addColumn('Store', 'suburb', Schema::TYPE_STRING);
        $this->addColumn('Store', 'stateId', Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0');
        $this->addColumn('Store', 'contactPerson', Schema::TYPE_STRING);
        $this->addColumn('Store', 'phone', Schema::TYPE_STRING);
        $this->addColumn('Store', 'abn', Schema::TYPE_STRING);
        $this->addColumn('Store', 'website', Schema::TYPE_STRING);
        $this->addColumn('Store', 'email', Schema::TYPE_STRING);
        $this->addColumn('Store', 'businessHours', Schema::TYPE_STRING);
        $this->addColumn('Store', 'storeProfile', Schema::TYPE_STRING);
        $this->addColumn('Store', 'imageId', Schema::TYPE_INTEGER);
    }

    public function down()
    {
        $this->dropColumn('Store', 'address1');
        $this->dropColumn('Store', 'address2');
        $this->dropColumn('Store', 'suburb');
        $this->dropColumn('Store', 'stateId');
        $this->dropColumn('Store', 'contactPerson');
        $this->dropColumn('Store', 'phone');
        $this->dropColumn('Store', 'abn');
        $this->dropColumn('Store', 'website');
        $this->dropColumn('Store', 'email');
        $this->dropColumn('Store', 'businessHours');
        $this->dropColumn('Store', 'storeProfile');
        $this->dropColumn('Store', 'imageId');
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
