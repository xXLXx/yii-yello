<?php

use yii\db\Schema;
use yii\db\Migration;

class m150608_045623_VehicleType extends Migration
{
    public function up()
    {
        $options = null;
        if ($this->db->driverName === 'mysql') {
            $options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        } 
        $this->createTable('VehicleType', [
            'id'    => Schema::TYPE_PK,
            'name'  => Schema::TYPE_STRING,
            'title' => Schema::TYPE_STRING,
            'createdAt'  => Schema::TYPE_INTEGER . ' NOT NULL',
            'updatedAt'  => Schema::TYPE_INTEGER . ' NOT NULL',
            'isArchived' => Schema::TYPE_BOOLEAN . ' DEFAULT 0'
        ], $options);
        
        $items = [
            [
                'name'  => 'car',
                'title' => 'Car',
            ],
            [
                'name'  => 'bike',
                'title' => 'Bike',
            ]
        ];
        foreach ($items as $item) {
            $this->insert('VehicleType', $item);
        }
        
        $this->renameColumn('Vehicle', 'typeId', 'vehicleTypeId');
    }

    public function down()
    {
        $this->renameColumn('Vehicle', 'vehicleTypeId', 'typeId');
        $this->dropTable('VehicleType');
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
