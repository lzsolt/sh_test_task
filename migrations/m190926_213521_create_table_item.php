<?php

use yii\db\Migration;

/**
 * Class m190926_213521_create_table_item
 */
class m190926_213521_create_table_item extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('item', array(
            'id' => 'pk',
            'artist' => 'VARCHAR(128) NOT NULL',
            'image_url' => 'VARCHAR(128) NOT NULL',
            'price' => 'FLOAT NOT NULL',
            'name' => 'VARCHAR(128) NOT NULL',
            'description' => 'LONGTEXT NOT NULL',
            'slug' => 'VARCHAR(128) NOT NULL',
            'added' => 'DATETIME NOT NULL',
            'manufacturer' => 'VARCHAR(128) NOT NULL',
            'item_type' => 'VARCHAR(64) NOT NULL',
            'created_date' => 'DATETIME NOT NULL DEFAULT NOW()',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190926_213521_create_table_item cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190926_213521_create_table_item cannot be reverted.\n";

        return false;
    }
    */
}
