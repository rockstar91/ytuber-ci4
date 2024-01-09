<?php namespace App\Database\Seeds;

class InitializeMythAuthRBAC extends \CodeIgniter\Database\Seeder
{
    protected $table = 'auth_groups';
    protected $groups = ['Administrators', 'Moderators', 'Members', 'Gold Members'];

    public function run()
    {
        $this->eraseGroups();
        $this->insertGroups($this->groups);
    }

    public function eraseGroups()
    {
        $this->db->query("DELETE FROM {$this->table}");
        $this->db->query("ALTER TABLE {$this->table} AUTO_INCREMENT=1");
    }

    public function insertGroups($groups)
    {
        foreach ($groups as $group) {
            $data = [
                'name' => $group
            ];

            $this->db->table('auth_groups')->insert($data);
        }
    }
}