<?php namespace App\Database\Seeds;

class InitializeAccountTypes extends \CodeIgniter\Database\Seeder
{
    protected $table = 'accounts_types';

    public function run()
    {
        $this->purgeTable($this->table);

        $data = [
            'name'          => 'Google Youtube',
            'pattern'       => '^http(s){0,1}://www\.youtube\.com/channel/([a-z0-9-_]{24})$',
            'example'       => 'https://www.youtube.com/channel/UC2qoLqo8RuV4P_88yhHCZIg',
            'model'         => 'App\Model\AccountGoogleYoutubeModel',
            'created_at'    => date('Y-m-d H:i:s')
        ];

        $this->db->table($this->table)->insert($data);


        $this->generateAccounts();

    }

    public function generateAccounts()
    {
        $this->purgeTable('accounts');
        $this->purgeTable('accounts_google_youtube');

        for($i = 0; $i < 1000; $i++)
        {

            // Добавление связей
            $account = [
                'user_id'           => 0,
                'account_type_id'   => 1,
                'active'            => true,
                'created_at'        => date('Y-m-d H:i:s')
            ];

            $this->db->table('accounts')->insert($account);

            // Добавление аккаунтов
            $accountGoogleYoutube = [
                'account_id'            => $this->db->insertID(),
                'gid'                   => 'gid #' . $i,
                'refresh_token'         => md5('token' . $i),
                'activity'              => $i,
            ];

            $this->db->table('accounts_google_youtube')->insert($accountGoogleYoutube);

        }

    }

    public function purgeTable($tableName)
    {
        $this->db->query("DELETE FROM {$tableName}");
        $this->db->query("ALTER TABLE {$tableName} AUTO_INCREMENT=1");
    }
}