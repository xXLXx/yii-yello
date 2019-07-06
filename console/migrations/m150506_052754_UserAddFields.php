<?php

use yii\db\Schema;
use yii\db\Migration;

class m150506_052754_UserAddFields extends Migration
{
    public function up()
    {
        $this->addColumn('User', 'lastName', Schema::TYPE_STRING);
        $this->addColumn('User', 'firstName', Schema::TYPE_STRING);
        $this->addColumn('User', 'photoId', Schema::TYPE_INTEGER);
        $this->addColumn('User', 'hasExtendedRights', Schema::TYPE_BOOLEAN);
    }

    public function down()
    {
        $this->dropColumn('User', 'lastName');
        $this->dropColumn('User', 'firstName');
        $this->dropColumn('User', 'photoId');
        $this->dropColumn('User', 'hasExtendedRights');
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
