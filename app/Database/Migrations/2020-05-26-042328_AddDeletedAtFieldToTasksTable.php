<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDeletedAtFieldToTasksTable extends Migration
{
	public function up()
	{
		//
        $fields = [
            'deleted_at' => ['type' => 'datetime', 'null' => true, 'after' => 'updated_at'],
        ];

        $this->forge->addColumn('tasks', $fields);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
