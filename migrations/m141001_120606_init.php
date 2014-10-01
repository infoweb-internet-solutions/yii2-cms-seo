<?php

use yii\db\Schema;
use yii\db\Migration;

class m141001_120606_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        
        // Create 'seo' table
        $this->createTable('{{%seo}}', [
            'id'            => Schema::TYPE_PK,
            'entity'        => "ENUM('page') NOT NULL DEFAULT 'page'",
            'entity_id'     => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
            'created_at'    => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
            'updated_at'    => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
        ], $tableOptions);

        // Create 'seo_lang' table
        $this->createTable('{{%seo_lang}}', [
            'seo_id'        => Schema::TYPE_INTEGER . ' NOT NULL',
            'language'      => Schema::TYPE_STRING . '(5) NOT NULL',
            'title'         => Schema::TYPE_STRING . '(255) NOT NULL',
            'description'   => Schema::TYPE_TEXT . ' NOT NULL',
            'created_at'    => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
            'updated_at'    => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
        ], $tableOptions);

        $this->addPrimaryKey('seo_id_language', '{{%seo_lang}}', ['seo_id', 'language']);
        $this->createIndex('language', '{{%seo_lang}}', 'language');
        $this->addForeignKey('FK_SEO_LANG_SEO_ID', '{{%seo_lang}}', 'seo_id', '{{%seo}}', 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable('seo_lang');
        $this->dropTable('seo');
    }
}
