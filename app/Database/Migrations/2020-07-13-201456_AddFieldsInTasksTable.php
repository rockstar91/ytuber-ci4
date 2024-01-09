<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFieldsInTasksTable extends Migration
{
	public function up()
	{
		// targetTime, channelAgeLimit, videosCountLimit

        $fields = [
            'targetTime'       => ['type' => 'SMALLINT', 'unsigned' => true, 'default' => 0],
            'channelAgeLimit'  => ['type' => 'SMALLINT', 'unsigned' => true, 'default' => 0],
            'videosCountLimit' => ['type' => 'SMALLINT', 'unsigned' => true, 'default' => 0],
        ];

        $this->forge->addColumn('tasks', $fields);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
