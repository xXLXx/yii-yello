<?php

use common\models\Invitation;
use common\models\InvitationStatus;
use yii\db\Migration;
use yii\db\Schema;

class m150626_064249_create_invitations_tables extends Migration
{
    private $table, $tableState, $tableFkState = 'fk_Invitation_stateId';

    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->table = Invitation::tableName();
        $this->tableState = InvitationStatus::tableName();
    }


    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable($this->tableState, [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' DEFAULT NULL',
            'createdAt' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'updatedAt' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'isArchived' => Schema::TYPE_BOOLEAN . ' DEFAULT 0'
        ], $tableOptions);

        $this->createTable($this->table, [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' DEFAULT NULL',
            'email' => Schema::TYPE_STRING . ' DEFAULT NULL',
            'statusId' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'createdAt' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'updatedAt' => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'isArchived' => Schema::TYPE_BOOLEAN . ' DEFAULT 0'
        ], $tableOptions);


        $this->addForeignKey($this->tableFkState, $this->table, 'statusId', $this->tableState, 'id', 'CASCADE', 'RESTRICT');

        foreach ([InvitationStatus::CONNECTED, InvitationStatus::PENDING, InvitationStatus::REGISTRATION] as $name) {
            $invStatus = new InvitationStatus();
            $invStatus->name = $name;
            $invStatus->save();
        }
    }

    public function down()
    {
        $this->dropForeignKey($this->tableFkState, $this->table);
        $this->dropTable($this->table);
        $this->dropTable($this->tableState);
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
