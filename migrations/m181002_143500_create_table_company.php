<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m181002_143500_create_table_company
 */
class m181002_143500_create_table_company extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%admin_company}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'TIN' => Schema::TYPE_STRING . ' NOT NULL',
            'general_director' => Schema::TYPE_STRING . ' NOT NULL',
            'address' => Schema::TYPE_STRING . ' NOT NULL',
            'status' => Schema::TYPE_STRING . ' NOT NULL',
        ], $tableOptions);


        $this->createTable('{{%company}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'TIN' => Schema::TYPE_STRING . ' NOT NULL',
            'general_director' => Schema::TYPE_STRING . ' NOT NULL',
            'address' => Schema::TYPE_STRING . ' NOT NULL',
            'admin_company_id' => Schema::TYPE_INTEGER . ' NOT NULL UNIQUE',
        ], $tableOptions);

        $this->addForeignKey('fk_company_company_id', '{{%company}}', 'admin_company_id',
            '{{%admin_company}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_company_company_id', '{{%company}}');
        $this->dropTable('{{%company}}');
        $this->dropTable('{{%admin_company}}');
    }
}
