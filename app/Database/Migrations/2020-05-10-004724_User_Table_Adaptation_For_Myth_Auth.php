<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserTableAdaptationForMythAuth extends Migration
{
    protected $removeColums = [
        'forgot_token',
        'confirm',
        'confirm_sended'
    ];

    public function removeColums()
    {
        foreach ($this->removeColums as $val) {
            $this->forge->dropColumn('user', $val);
        }
    }

    function addMythAuthColumns()
    {
        $fields = [
            'reset_hash'       => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'reset_at'         => ['type' => 'datetime', 'null' => true],
            'reset_expires'    => ['type' => 'datetime', 'null' => true],
            'activate_hash'    => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'status'           => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'status_message'   => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
            'active'           => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'force_pass_reset' => ['type' => 'tinyint', 'constraint' => 1, 'null' => 0, 'default' => 0],
            'updated_at'       => ['type' => 'datetime', 'null' => true],
            'deleted_at'       => ['type' => 'datetime', 'null' => true],
        ];

        $this->forge->addColumn('user', $fields);

        // TODO: Добааление ключей работает только с созданием таблицы
        //$this->forge->addUniqueKey('email');
        //$this->forge->addUniqueKey('username');

    }

	public function up()
	{
		//
        $fields = [
            'id' => [
                'name' => 'id',
                'type' => 'INT',
                'constraint' => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'mail' => [
                'name' => 'email',
                'type' => 'varchar',
                'constraint' => 255
            ],
            'name' => [
                'name' => 'username',
                'type' => 'varchar',
                'constraint' => 255
            ],
            'time' => [
                'name' => 'created_at',
                'type' => 'datetime',
                'null' => true
            ],
        ];

        $this->forge->modifyColumn('user', $fields);

        $this->addMythAuthColumns();

        $this->removeColums();

        $this->forge->dropTable('users');
        $this->forge->renameTable('user', 'users');

        //$seeder = \Config\Database::seeder();
        //->call('ChangePasswordHashSeed');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
