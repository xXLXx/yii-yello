<?php

use yii\db\Schema;
use yii\db\Migration;

class m150803_115452_Signupinvitations extends Migration
{
    private $table = 'signupinvitations';
    private $idxUserfk = 'fk_signupinvitations_userfk';
    private $idxStoreownerfk = 'fk_signupinvitations_storeownerfk';
    private $fkToUser = 'fk_signupinvitations_user';
    private $fkToStoreowner = 'fk_signupinvitations_storeowner';

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('signupinvitations', [
            'id' => Schema::TYPE_PK,
            'userfk' => Schema::TYPE_INTEGER,
            'emailaddress' => Schema::TYPE_STRING,
            'invitationcode' => Schema::TYPE_STRING,
            'storeownerfk' => Schema::TYPE_INTEGER,
            'datecreated' => Schema::TYPE_DATE,
            'dateupdated' => Schema::TYPE_DATE,
            'expires' => Schema::TYPE_STRING,
            'sent' => Schema::TYPE_BOOLEAN,
            'isArchived' => Schema::TYPE_BOOLEAN,
            'isRead' => Schema::TYPE_BOOLEAN,
            'isSignedUp' => Schema::TYPE_BOOLEAN
        ], $tableOptions);
        $this->createIndex($this->idxUserfk, $this->table, 'userfk');
        $this->createIndex($this->idxStoreownerfk, $this->table, 'storeownerfk');
        $this->addForeignKey($this->fkToUser, $this->table, 'userfk', 'User', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey($this->fkToStoreowner, $this->table, 'storeownerfk', 'Storeowner', 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        echo "m150803_115452_Signupinvitations cannot be reverted.\n";

        return false;
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
