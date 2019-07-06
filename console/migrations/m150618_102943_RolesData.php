<?php

use yii\db\Schema;
use yii\db\Migration;

class m150618_102943_RolesData extends Migration
{
    public function up()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS = 0');
        $this->truncateTable('Role');
        $this->execute('SET FOREIGN_KEY_CHECKS = 1');
        $roles = [
            [
                'name'  => 'superAdmin',
                'title' => 'Super Admin'
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
            [
                'title' => 'Store Owner',
                'name' => 'storeOwner'
            ],
            [
                'title' => 'Employee',
                'name' => 'employee'
            ],
            [
                'name'  => 'yelloAdmin',
                'title' => 'Yello Admin'
            ]
        ];
        foreach ($roles as $item) {
            $this->insert('Role', $item);
        }
    }

    public function down()
    {
        $this->execute('SET FOREIGN_KEY_CHECKS = 0');
        $this->truncateTable('Role');
        $this->execute('SET FOREIGN_KEY_CHECKS = 1');
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
