<?php namespace App\Database\Migrations;

use App\Database\AdvancedMigration;
use CodeIgniter\Database\Migration;

class NotificationsModify extends AdvancedMigration
{
	public function up()
	{
		//
        $fields = [
            'time' => [
                'name' => 'created_at',
                'type' => 'datetime',
                'null' => true,
            ],
            'user_id' => [
                'name' => 'user_id',
                'type' => 'INT',
                'constraint' => 11,
                'unsigned'       => true
            ],
            'task_id' => [
                'name' => 'task_id',
                'type' => 'INT',
                'constraint' => 11,
                'unsigned'       => true
            ],
            'task_type_id' => [
                'name' => 'task_type_id',
                'type' => 'INT',
                'constraint' => 11,
                'unsigned'       => true
            ],
            'task_time' => [
                'name' => 'task_target_time',
                'type' => 'INT',
                'constraint' => 11,
                'unsigned'       => true
            ],
        ];

        $this->forge->modifyColumn('notifications', $fields);

        $this->db->query('SET FOREIGN_KEY_CHECKS=0;');
        $this->addNewForeignKey('notifications', 'user_id', 'users', 'id', 'cascade', 'cascade');
        $this->addNewForeignKey('notifications', 'task_id', 'tasks', 'id', 'cascade', 'cascade');
        $this->addNewForeignKey('notifications', 'task_type_id', 'tasks_types', 'id', 'cascade', 'cascade');
        $this->db->query('SET FOREIGN_KEY_CHECKS=1;');
    }

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
