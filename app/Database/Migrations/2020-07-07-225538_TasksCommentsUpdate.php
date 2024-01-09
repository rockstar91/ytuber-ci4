<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TasksCommentsUpdate extends Migration
{
	public function up()
	{
		//
        $fields = [
            'updated_at'       => ['type' => 'datetime', 'null' => true],
            'deleted_at'       => ['type' => 'datetime', 'null' => true],
        ];

        $this->forge->addColumn('tasks_comments', $fields);


        $fields = [
            'id' => [
                'name' => 'id',
                'type' => 'INT',
                'constraint' => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'time' => [
                'name' => 'created_at',
                'type' => 'datetime',
                'null' => true
            ],

            'time' => [
                'name' => 'created_at',
                'type' => 'datetime',
                'null' => true
            ],
        ];

        $this->forge->modifyColumn('tasks_comments', $fields);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
