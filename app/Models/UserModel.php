<?php namespace App\Models;

use App\Traits\Models\DisplayMode;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Validation\ValidationInterface;
use Myth\Auth\Models\UserModel as MythAuth_UserModel;

use App\Entities\User;

class UserModel extends MythAuth_UserModel
{
    use DisplayMode;

    protected $table      = 'users';
    protected $primaryKey = 'id';

    protected $useSoftDeletes = true;

    protected $returnType = 'App\Entities\User';

    public function __construct(ConnectionInterface &$db = null, ValidationInterface $validation = null)
    {
        parent::__construct($db, $validation);

        $this->allowedFields = array_merge(
            $this->allowedFields,
            [
                'referrer_id',
                'sub_news',
                'sub_transaction',
                'sub_statistic',
                'sub_notification'
            ]
        );
    }

    /**
     * @param $apiKey
     * @return array|null|object
     */
    public function getUserByApiKey($apiKey) : ?User
    {
        if(strlen($apiKey) == 40)
            return $this->where('api_key', $apiKey)->first();

        return null;
    }

    function getActiveReferralsTotal(int $referrerId)
    {
        $lastseen = date('Y-m-d H:i:s', time() - (7 * 86400));
        $createdAt = date('Y-m-d H:i:s', time() - (14 * 86400));

        return $this->select('COUNT(id) as total')
            ->where('referrer_id', intval($referrerId))
            ->where('lastseen >', $lastseen) // были менее 7 дней назад
            ->where('created_at <', $createdAt)  // зарегистрировались более 14 дней назад
            ->first()->total;
        //$this->db->where('channel_available', 1); // канал доступен
        //$this->db->where('done >', 50); // есть выполнения задач
        //$query = $this->db->get($this->table);

        //return $query->row() ? intval($query->row()->total) : 0;
    }

    public function getReferralsTotalEarned(int $referrerId)
    {
        return $this->select('SUM(earned) as total')
            ->where('earned >', 0)
            ->first()->total;
    }

    public function decreaseBalance(int $userId, $sum = 0):?int
    {
        $this->db->query("UPDATE {$this->table} SET balance = balance-{$sum} WHERE id = '{$userId}' ");

        return $this->db->affectedRows();
    }

    public function increaseBalance(int $userId, $sum = 0):?int
    {
        if ($sum <= 0) {
            return true;
        }

        $this->db->query("UPDATE {$this->table} SET balance = balance+{$sum} WHERE id = '{$userId}' ");

        return $this->db->affectedRows();
    }

    public function increase(int $userId, $data = [])
    {
        if (!is_array($data)) {
            return;
        }

        $this->where('id', $userId, true);
        foreach ($data as $key => $value) {
            $this->set($key, $key . '+' . $value, false);
        }
        $this->update();

        return $this->db->affectedRows();
    }
}