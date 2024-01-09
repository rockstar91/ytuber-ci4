<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableAccountsGoogleYoutube extends Migration
{
	public function up()
	{
        $this->forge->addField([
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],

            'account_id'            => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],

            'gid'                   => ['type' => 'varchar', 'constraint' => 255],
            'refresh_token'         => ['type' => 'varchar', 'constraint' => 255],
            'avatar_url'            => ['type' => 'varchar', 'constraint' => 255],
            'channel_id'            => ['type' => 'varchar', 'constraint' => 255],
            'channel_available'     => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'channel_published_at'  => ['type' => 'datetime', 'null' => true],
            'activity'              => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'activity_updated_at'   => ['type' => 'datetime', 'null' => true],

        ]);
        $this->forge->addKey('id', true);
        //$this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('account_id', 'accounts', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('accounts_google_youtube', true);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
        $this->forge->dropTable('accounts_google_youtube', true);
	}
}
