<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use App\Database\AdvancedMigration;

class AddForeignsToTask extends AdvancedMigration
{
	public function up()
	{
		//
        $fields = [
            'category_id' => [
                'name' => 'category_id',
                'type' => 'INT',
                'constraint' => 11,
                'unsigned'       => true
            ],
            'user_id' => [
                'name' => 'user_id',
                'type' => 'INT',
                'constraint' => 11,
                'unsigned'       => true
            ],
            'type_id' => [
                'name' => 'type_id',
                'type' => 'INT',
                'constraint' => 11,
                'unsigned'       => true
            ],
        ];


        $this->forge->modifyColumn('tasks', $fields);

        $db = \Config\Database::connect();
        $db->query('SET FOREIGN_KEY_CHECKS=0;');
        $db->query('DELETE FROM tasks WHERE category_id = 0 OR type_id = 103;');


        $this->addNewForeignKey('tasks', 'category_id', 'tasks_categories', 'id', 'cascade', 'cascade');

        $this->addNewForeignKey('tasks', 'type_id', 'tasks_types', 'id', 'cascade', 'cascade');

        $this->addNewForeignKey('tasks', 'user_id', 'users', 'id', 'cascade', 'cascade');


    }

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
