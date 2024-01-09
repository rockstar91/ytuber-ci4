<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNewColumnsInAccountSystemTables extends Migration
{
	public function up()
	{
		//
        $fields = [
            'active'           => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'created_at'       => ['type' => 'datetime', 'null' => true],
            'updated_at'       => ['type' => 'datetime', 'null' => true],
            'deleted_at'       => ['type' => 'datetime', 'null' => true],
        ];

        $this->forge->addColumn('accounts', $fields);


        $fields = [
            'model'            => ['type' => 'varchar', 'constraint' => 255],
            'created_at'       => ['type' => 'datetime', 'null' => true],
            'updated_at'       => ['type' => 'datetime', 'null' => true],
        ];

        $this->forge->addColumn('accounts_types', $fields);

	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
