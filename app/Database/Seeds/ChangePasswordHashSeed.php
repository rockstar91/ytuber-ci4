<?php namespace App\Database\Seeds;

use Myth\Auth\Config;


class ChangePasswordHashSeed extends \CodeIgniter\Database\Seeder
{
    protected $table = 'users';
    protected $limit = 1000;

    public function run()
    {
        $builder = $this->db->table($this->table)->select('id, password, disabled');
        $query   = $builder->get($this->limit);

        foreach ($query->getResult() as $row)
        {
            $password_hash = $this->getPasswordHash($row->password);
            $data = [
                'password_hash' => $password_hash,
                'active'        => (!$row->disabled)
            ];
            $builder->update($data, ['id' => $row->id]);

            echo $row->id . ' ' . $row->password . ' ' . $password_hash . '<br/>' . PHP_EOL;
        }
    }

    public function getPasswordHash(string $password)
    {
        $config = config('Auth');


        if (
            (defined('PASSWORD_ARGON2I') && $config->hashAlgorithm == PASSWORD_ARGON2I)
            ||
            (defined('PASSWORD_ARGON2ID') && $config->hashAlgorithm == PASSWORD_ARGON2ID)
        )
        {
            $hashOptions = [
                'memory_cost' => $config->hashMemoryCost,
                'time_cost'   => $config->hashTimeCost,
                'threads'     => $config->hashThreads
            ];
        }
        else
        {
            $hashOptions = [
                'cost' => $config->hashCost
            ];
        }

        return password_hash(
            base64_encode(
                hash('sha384', $password, true)
            ),
            $config->hashAlgorithm,
            $hashOptions
        );
    }


}