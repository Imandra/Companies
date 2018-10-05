<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m181004_212114_create_table_public_contact
 */
class m181004_212114_create_table_public_contact extends Migration
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

        $this->createTable('{{%public_contact}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'phone_number' => Schema::TYPE_STRING . ' NOT NULL',
            'email' => Schema::TYPE_STRING . ' NOT NULL',
            'company_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'contact_id' => Schema::TYPE_INTEGER . ' NOT NULL UNIQUE',
        ], $tableOptions);

        $this->addForeignKey('fk_public_contact_company_id', '{{%public_contact}}', 'company_id',
            '{{%company}}', 'id', 'CASCADE');

        $this->addForeignKey('fk_public_contact_contact_id', '{{%public_contact}}', 'contact_id',
            '{{%contact}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_public_contact_contact_id', '{{%public_contact}}');
        $this->dropForeignKey('fk_public_contact_company_id', '{{%public_contact}}');
        $this->dropTable('{{%public_contact}}');
    }
}
