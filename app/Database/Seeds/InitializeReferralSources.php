<?php


namespace App\Database\Seeds;


class InitializeReferralSources extends \CodeIgniter\Database\Seeder
{
    protected $table = 'referral_sources';

    public function run()
    {
        $this->purgeTable($this->table);

        $list = [
            'Любой',
            'Ytuber',
            'Desktop-клиент',
            'Web-клиент',
            'Google-поиск',
            'Yandex-поиск',
            'Instagram',
            'Другой',
        ];

        foreach ($list as $val)
        {
            $data = [
                'name'          => $val,
                'created_at'    => date('Y-m-d H:i:s')
            ];

            $this->db->table($this->table)->insert($data);
        }


    }

    public function purgeTable($tableName)
    {
        $this->db->query("DELETE FROM {$tableName}");
        $this->db->query("ALTER TABLE {$tableName} AUTO_INCREMENT=1");
    }
}