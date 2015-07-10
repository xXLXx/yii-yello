<?php

use yii\db\Schema;
use yii\db\Migration;

class m150624_031746_add_user_parent_field extends Migration
{
    public function up()
    {
        $this->addColumn('User', 'parentId', Schema::TYPE_INTEGER . ' DEFAULT NULL');
    }

    public function down()
    {
        $this->dropColumn('User', 'parentId');
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
