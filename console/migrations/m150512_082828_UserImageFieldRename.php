<?php

use yii\db\Migration;

class m150512_082828_UserImageFieldRename extends Migration
{
    public function up()
    {
        $this->renameColumn('User', 'photoId', 'imageId');
    }

    public function down()
    {
        $this->renameColumn('User', 'imageId', 'photoId');
    }
}
