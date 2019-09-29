<?php

use yii\db\Migration;

/**
 * Class m190926_190537_create_table_queue
 */
class m190926_190537_create_table_queue extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('queue', array(
            'id' => 'pk',
            'created_date' => 'DATETIME NOT NULL DEFAULT NOW()',
            'fail_count' => 'INT NOT NULL DEFAULT 0',
            'message' => 'LONGTEXT NOT NULL',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190926_190537_create_table_queue cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190926_190537_create_table_queue cannot be reverted.\n";

        return false;
    }
    */
}
