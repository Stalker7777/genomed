<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%counter}}`.
 */
class m250419_074014_create_counter_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%counter}}', [
            'id' => $this->primaryKey(),
            'hrefshort_id' => $this->integer()->notNull(),
            'ip' => $this->string(50)->notNull(),
            'count' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-counter-hrefshort_id',
            '{{%counter}}',
            'hrefshort_id'
        );

        $this->addForeignKey(
            'fk-counter-hrefshort_id',
            '{{%counter}}',
            'hrefshort_id',
            '{{%hrefshort}}',
            'id',
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-counter-hrefshort_id',
            '{{%counter}}'
        );

        $this->dropIndex(
            'idx-counter-hrefshort_id',
            '{{%counter}}'
        );

        $this->dropTable('{{%counter}}');
    }
}
