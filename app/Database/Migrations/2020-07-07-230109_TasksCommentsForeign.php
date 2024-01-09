<?php namespace App\Database\Migrations;

use App\Database\AdvancedMigration;
use CodeIgniter\Database\Migration;

class TasksCommentsForeign extends AdvancedMigration
{
	public function up()
	{
		//
        $fields = [
            'task_id' => [
                'name' => 'task_id',
                'type' => 'INT',
                'constraint' => 11,
                'unsigned'       => true
            ],
        ];

        $this->db->query('SET FOREIGN_KEY_CHECKS=0;');

        $this->forge->modifyColumn('tasks_comments', $fields);

        $this->addNewForeignKey('tasks_comments', 'task_id', 'tasks', 'id', 'cascade', 'cascade');

        $this->db->query('SET FOREIGN_KEY_CHECKS=1;');
    }

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
