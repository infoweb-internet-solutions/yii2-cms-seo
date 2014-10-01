<?php

use yii\db\Schema;
use yii\db\Migration;

class m141001_120606_create_seo_table extends Migration
{
    public function up()
    {
        $tableOptions = "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB";

        $this->createTable('{{%seo}}', [
            'id' => 'INT(10) UNSIGNED NOT NULL AUTO_INCREMENT',
            'entity' => 'ENUM(\'page\') NOT NULL',
            'entity_id' => 'INT(10) UNSIGNED NOT NULL',
            'created_at' => 'INT(10) UNSIGNED NOT NULL',
            'updated_at' => 'INT(10) UNSIGNED NOT NULL',
            0 => 'PRIMARY KEY (`id`)'
        ], $tableOptions);

        $this->createTable('{{%seo_lang}}', [
            'seo_id' => 'INT(10) UNSIGNED NOT NULL',
            'language' => 'VARCHAR(5) NOT NULL',
            'title' => 'VARCHAR(255) NOT NULL',
            'description' => 'VARCHAR(255) NOT NULL',
            'created_at' => 'INT(10) UNSIGNED NOT NULL',
            'updated_at' => 'INT(10) UNSIGNED NOT NULL',
            0 => 'PRIMARY KEY (`seo_id`)',
            0 => 'PRIMARY KEY (`language`)'
        ], $tableOptions);

        /*
         * UNIQUE INDEX `seo_id_language` (`seo_id`, `language`),
	     * INDEX `language` (`language`),*
         */

        $this->addForeignKey('fk_seo_seo_lang', '{{%seo_lang}}', 'seo_id', '{{%seo}}', 'id', 'CASCADE', 'DELETE');
    }

    public function down()
    {
        $this->dropTable('seo_lang');
        $this->dropTable('seo');
    }
}
