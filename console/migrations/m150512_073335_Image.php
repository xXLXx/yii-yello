<?php

use yii\db\Schema;
use yii\db\Migration;

class m150512_073335_Image extends Migration
{
    public function up()
    {
        $options = null;
        if ($this->db->driverName === 'mysql') {
            $options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('Image', [
            'id' => Schema::TYPE_PK,
            'createdAt' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updatedAt' => Schema::TYPE_INTEGER . ' NOT NULL',
            'isArchived' => Schema::TYPE_BOOLEAN . ' DEFAULT 0',
            'originalUrl' => Schema::TYPE_STRING,
            'largeUrl' => Schema::TYPE_STRING,
            'thumbUrl' => Schema::TYPE_STRING,
            'title' => Schema::TYPE_STRING,
            'alt' => Schema::TYPE_STRING,
        ], $options);
    }

    public function down()
    {
        $this->dropTable('Image');
    }
}
