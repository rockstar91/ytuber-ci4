<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateTasksTableFields extends Migration
{
	public function up()
	{
        //

        $fields = [
            'added' => [
                'name' => 'created_at',
                'type' => 'DATETIME',
            ],
            'updated' => [
                'name' => 'updated_at',
                'type' => 'DATETIME',
            ],
            'completion' => [
                'name' => 'completed_at',
                'type' => 'DATETIME',
            ],
        ];

        $this->forge->modifyColumn('tasks', $fields);


        $this->forge->dropColumn('tasks', 'report');
        $this->forge->dropColumn('tasks', 'description');
        $this->forge->dropColumn('tasks', 'removed');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
