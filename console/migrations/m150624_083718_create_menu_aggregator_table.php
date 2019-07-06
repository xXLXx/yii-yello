<?php

use yii\db\Migration;
use yii\db\Schema;

class m150624_083718_create_menu_aggregator_table extends Migration
{
    private $table = 'MenuAggregator';
    private $fkToUser = 'fk_menuAggregator_user';
    private $fkToCompany = 'fk_menuAggregator_company';
    private $idxUserId = 'idx_menuAggregator_userId';
    private $idxCompanyId = 'idx_menuAggregator_companyId';

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('MenuAggregator', [
            'id' => Schema::TYPE_PK,
            'companyId' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'userId' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'corporateScheduleId' => Schema::TYPE_INTEGER . ' DEFAULT NULL'
        ], $tableOptions);
        $this->addColumn($this->table, 'createdAt', Schema::TYPE_INTEGER . ' NOT NULL');
        $this->addColumn($this->table, 'updatedAt', Schema::TYPE_INTEGER . ' NOT NULL');
        $this->addColumn($this->table, 'isArchived', Schema::TYPE_BOOLEAN . ' DEFAULT 0');
        $this->createIndex($this->idxUserId, $this->table, 'userId');
        $this->createIndex($this->idxCompanyId, $this->table, 'companyId');
        $this->addForeignKey($this->fkToUser, $this->table, 'userId', 'User', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey($this->fkToCompany, $this->table, 'companyId', 'Company', 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropForeignKey($this->fkToCompany, $this->table);
        $this->dropForeignKey($this->fkToUser, $this->table);
        $this->dropIndex($this->idxCompanyId, $this->table);
        $this->dropIndex($this->idxUserId, $this->table);
        $this->dropTable($this->table);
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
