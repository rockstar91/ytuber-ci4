<?php namespace App\Database\Migrations;

use App\Database\AdvancedMigration;
use CodeIgniter\Database\Migration;

class ModifyAccountsTable extends AdvancedMigration
{
	public function up()
	{
		//

        $this->forge->dropColumn('accounts', 'url');
        $this->forge->dropColumn('accounts', 'status');

        //
        $fields = [
            'user_id' => [
                'name' => 'user_id',
                'type' => 'INT',
                'constraint' => 11,
                'unsigned'       => true
            ],
            'account_type_id' => [
                'name' => 'account_type_id',
                'type' => 'INT',
                'constraint' => 11,
                'unsigned'       => true
            ],
        ];

        $this->forge->modifyColumn('accounts', $fields);

        $this->addNewForeignKey('accounts', 'user_id', 'users', 'id', 'cascade', 'cascade');
        $this->addNewForeignKey('accounts', 'account_type_id', 'accounts_types', 'id', 'cascade', 'cascade');

        //$this->forge->renameTable('accounts', 'accounts_relations');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
