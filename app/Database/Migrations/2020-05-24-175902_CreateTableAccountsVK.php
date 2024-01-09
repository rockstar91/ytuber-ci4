<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableAccountsVK extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'account_id'            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'uid'                   => ['type' => 'varchar', 'constraint' => 255],
            'refresh_token'         => ['type' => 'varchar', 'constraint' => 255]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('account_id', 'accounts', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('accounts_vk', true);
    }

    //--------------------------------------------------------------------

    public function down()
    {
        //
        $this->forge->dropTable('accounts_vk', true);
    }
}
