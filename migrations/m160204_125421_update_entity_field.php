<?php

use yii\db\Migration;
use yii\db\Schema;

class m160204_125421_update_entity_field extends Migration
{
    public function up()
    {
        $this->alterColumn('seo', 'entity', Schema::TYPE_STRING . '(255) NOT NULL');
    }

    public function down()
    {
        echo "m160204_125421_update_entity_field cannot be reverted.\n";

        return false;
    }
}
