<?php

use yii\db\Schema;
use yii\db\Migration;

class m150506_035355_Role extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('Role', [
            'id'    => Schema::TYPE_PK,
            'name'  => Schema::TYPE_STRING,
            'title' => Schema::TYPE_STRING
        ], $tableOptions);
        $roles = [
            [
                'name'  => 'superAdmin',
                'title' => 'SuperAdmin'
            ],
            [
                'name'  => 'franchiser',
                'title' => 'Franchiser'
            ],
            [
                'name'  => 'driver',
                'title' => 'Driver'
            ],
            [
                'name'  => 'manager',
                'title' => 'Manager'
            ],
            [
                'name'  => 'user',
                'title' => 'User'
            ],
        ];
        foreach ($roles as $item) {
            $this->insert('Role', $item);
        }
    }

    public function down()
    {
        $this->dropTable('Role');
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
