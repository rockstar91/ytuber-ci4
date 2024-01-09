<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ArticlesTable extends Migration
{
    protected $table = 'articles';

	public function up()
	{
		//
        // referral_sources
        $this->forge->addField([
            'id'    => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'  => ['type' => 'varchar', 'constraint' => 255],
            'html'  => ['type' => 'TEXT'],
            'created_at'       => ['type' => 'datetime', 'null' => true],
            'updated_at'       => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable($this->table, true);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
        $this->forge->dropTable($this->table, true);
	}
}
