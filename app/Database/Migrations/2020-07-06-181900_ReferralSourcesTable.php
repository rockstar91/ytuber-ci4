<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ReferralSourcesTable extends Migration
{
	public function up()
	{
		// referral_sources
        $this->forge->addField([
            'id'    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'  => ['type' => 'varchar', 'constraint' => 255],
            'created_at'       => ['type' => 'datetime', 'null' => true],
            'updated_at'       => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('referral_sources', true);

        // tasks_to_referral_sources
        $this->forge->addField([
            'id'                    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'referral_source_id'    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'task_id'               => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'created_at'            => ['type' => 'datetime', 'null' => true],
            'updated_at'            => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('referral_source_id', 'referral_sources', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('task_id', 'tasks', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tasks_to_referral_sources', true);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
        $this->forge->dropTable('referral_sources', true);
        $this->forge->dropTable('tasks_to_referral_sources', true);
	}
}