<?php namespace App\Database\Seeds;

use App\Models\AccountGoogleYoutubeModel;

class ExtractGoogleAccountsFromUsersTableToGoogleYoutubeAccountsTable extends \CodeIgniter\Database\Seeder
{
    protected $accountTypeId = 1;
    protected $table = 'accounts_google_youtube';
    protected $limit = 10000;

    public function run()
    {
        //
        $this->db->query("DELETE FROM accounts", $this->table, true);
        $this->db->query("ALTER TABLE accounts AUTO_INCREMENT=1");

        $this->db->query("DELETE FROM {$this->table}", $this->table, true);
        $this->db->query("ALTER TABLE {$this->table} AUTO_INCREMENT=1");

        $selectFields = 'id, gid, refresh_token, avatar, channel, channel_available, channel_published, activity, activity_updated_at, created_at';

        $builder = $this->db->table('users')->select($selectFields)->where('gid >', 0);
        $query   = $builder->get($this->limit);

        $model = new AccountGoogleYoutubeModel();

        foreach ($query->getResult() as $row)
        {


            $account = [
                'user_id'               => $row->id,
                'account_type_id'       => $this->accountTypeId,
                //'url'                   => '',
                //'account_id'            => $account_id,
                'gid'                   => $row->gid,
                'refresh_token'         => $row->refresh_token,
                'avatar_url'            => $row->avatar,
                'channel_id'            => $row->channel,
                'channel_available'     => $row->channel_available,
                'channel_published_at'  => $this->dateOrNull($row->channel_published),
                'activity'              => $row->activity,
                'activity_updated_at'   => $this->dateOrNull($row->activity_updated_at),
                //'active'                => true,
                //'created_at'            => $this->dateOrNull($row->created_at),
            ];

            $model->save($account);

            //$this->db->table($this->table)->insert($account);
        }
    }

    public function dateOrNull($date)
    {
        return ($date > 0) ? $date : null;
    }

}