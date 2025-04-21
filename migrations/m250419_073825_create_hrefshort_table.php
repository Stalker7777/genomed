<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%hrefshort}}`.
 */
class m250419_073825_create_hrefshort_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%hrefshort}}', [
            'id' => $this->primaryKey(),
            'href_long' => $this->string(1000)->notNull(),
            'href_short' => $this->string(50)->notNull(),
            'qr_image' => $this->string(255)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%hrefshort}}');
    }
}
