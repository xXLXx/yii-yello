<?php

use yii\db\Schema;
use yii\db\Migration;

class m150606_071654_Vehicle extends Migration
{
    public function up()
    {
        $options = null;
        if ($this->db->driverName === 'mysql') {
            $options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('Vehicle', [
            'id' => Schema::TYPE_PK,
            'typeId' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 1',
            'registration' => Schema::TYPE_STRING,
            'make' => Schema::TYPE_STRING,
            'model' => Schema::TYPE_STRING,
            'year' => Schema::TYPE_STRING,
            'imageId' => Schema::TYPE_INTEGER,
            'licenseNumber' => Schema::TYPE_INTEGER,
            'licensePhotoId' => Schema::TYPE_INTEGER,
            'userId' => Schema::TYPE_INTEGER,
            'createdAt' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updatedAt' => Schema::TYPE_INTEGER . ' NOT NULL',
            'isArchived' => Schema::TYPE_BOOLEAN . ' DEFAULT 0',
        ], $options);
    }

    public function down()
    {
        $this->dropTable('Vehicle');
    }
}
