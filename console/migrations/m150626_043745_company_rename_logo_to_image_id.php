<?php

use yii\db\Schema;
use yii\db\Migration;

class m150626_043745_company_rename_logo_to_image_id extends Migration
{

    public function up()
    {
        $this->renameColumn('Company', 'logo', 'imageId');
        $this->alterColumn('Company', 'imageId', Schema::TYPE_INTEGER);

        $this->addForeignKey('company_imageId', 'Company', 'imageId', 'Image', 'id');
    }

    public function down()
    {
        $this->dropForeignKey('company_imageId', 'Company');

        $this->renameColumn('Company', 'imageId', 'logo');
        $this->alterColumn('Company', 'logo', Schema::TYPE_STRING);
    }
    
}
