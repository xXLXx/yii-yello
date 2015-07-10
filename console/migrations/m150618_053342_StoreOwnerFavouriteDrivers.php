<?php

use yii\db\Schema;
use yii\db\Migration;

class m150618_053342_StoreOwnerFavouriteDrivers extends Migration
{
    public function up()
    {
        $options = null;
        if ($this->db->driverName === 'mysql') {
            $options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('StoreOwnerFavouriteDrivers', [
            'id'    => Schema::TYPE_PK,
            'storeOwnerId' => Schema::TYPE_INTEGER,
            'driverId' => Schema::TYPE_INTEGER,
            'createdAt'  => Schema::TYPE_INTEGER . ' NOT NULL',
            'updatedAt'  => Schema::TYPE_INTEGER . ' NOT NULL',
            'isArchived' => Schema::TYPE_BOOLEAN . ' DEFAULT 0'
        ], $options);
        $this->addForeignKey('storeOwnerFavouriteDrivers_storeOwnerId', 'StoreOwnerFavouriteDrivers', 'storeOwnerId', 'StoreOwner', 'id');
        $this->addForeignKey('storeOwnerFavouriteDrivers_driverId', 'StoreOwnerFavouriteDrivers', 'driverId', 'User', 'id');
    }

    public function down()
    {
        $this->dropTable('StoreOwnerFavouriteDrivers');
    }
}
