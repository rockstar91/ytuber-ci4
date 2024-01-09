<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

use Config\Database;

class Initial extends Migration
{

    protected $dropTables = [
        'geo_city',
        'geo_country',
        'geo_region',
        'geo_to_task',
        'loginfail',
        'penalty',
        'paycode',
        'setting'
    ];

    protected $renameTables = [
        'account' => 'accounts',
        'account_type' => 'accounts_types',
        'done' => 'completions',
        'task' => 'tasks',
        'category' => 'tasks_categories',
        'comment' => 'tasks_comments',
        'task_alternate_ids' => 'tasks_alternate_ids',
        'notification' => 'notifications',
        'payout' => 'payouts',
        'payment_system' => 'payments_systems',
        'refund' => 'refunds',
        'transaction' => 'transactions',
        'type' => 'tasks_types'
    ];

    public function renameTables($listTables, $rollback=false)
    {
        foreach ($listTables as $key=>$val)
        {
            if(!$rollback)
            {
                $this->forge->renameTable($key, $val);
            }
            else
            {
                $this->forge->renameTable($val, $key);
            }
        }
    }

    public function dropTables($listTables, $excludeTables=array())
    {
       foreach ($listTables as $tableName)
       {
           if(is_array($excludeTables) && !in_array($tableName, $excludeTables))
               $this->forge->dropTable($tableName);
       }
    }

    public function mysqlImportFile($filename)
    {
        $config = new Database;
        $group  = $config->defaultGroup;

        $username = $config->$group['username'];
        $password = $config->$group['password'];
        $database = $config->$group['database'];

        $sqlFile = dirname(__FILE__) . '/' . $filename;

        $command = $password
                ? "mysql -u{$username} -p{$password} {$database} < {$sqlFile}"
                : "mysql -u{$username} {$database}  < {$sqlFile}";

        system($command);
    }

	public function up()
	{
		//
        echo "Database intaial migration...".PHP_EOL;

        $this->down();

        $this->mysqlImportFile('structure.sql');
        $this->mysqlImportFile('ytuber.sql');

        $this->renameTables($this->renameTables);
        $this->dropTables($this->dropTables);

        echo 'Complete initial migration. '.PHP_EOL;

        $fields = [
            'id' => [
                'name' => 'id',
                'type' => 'INT',
                'constraint' => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],
        ];


        foreach ($this->renameTables as $k=>$v)
        {
            $this->forge->modifyColumn($v, $fields);
        }

        //$this->forge->modifyColumn('accounts_types', $fields);

	}


	//----------------------
    //----------------------------------------------

	public function down()
	{
        //
        $tables = Database::connect()->listTables();
        $this->dropTables($tables, array('migrations'));
	}
}
