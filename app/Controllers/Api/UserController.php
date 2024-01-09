<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 12.05.2020
 * Time: 15:39
 */

namespace App\Controllers\Api;

use Config\Database;

class UserController extends BaseApiController
{

    protected $modelName = '\App\Models\UserModel';

    protected $methodsMapping = [
        'getBalance'    => 'getMyBalance',
        'getDoneDay'    => 'getMyDoneDay',
        'getClientStat' => 'getStat',
        //'me'            => 'show'
    ];

    public $helpers = ['cache'];

    protected $perPage = 15;
    protected $pageSegment = 4;

    protected $latestReferralListLimit = 5;

    public function __construct()
    {
        $config = new \Config\Pager();
        $this->perPage = $config->perPage;
    }

    public function show($id = null)
    {
        $fields = ['id', 'avatar', 'username', 'created_at', 'done', 'lastseen'];

        $user = $this->model->select($fields)
            ->where('id', (int) $id)
            ->first();

        if(! $user ) {
            return $this->failNotFound();
        }

        return $this->respond($user);
    }

    public function me()
    {
        $user = $this->user->getAttributes([
            'id', 'avatar',
            'username', 'email', 'rub',
            'balance', 'credits',
            'earned', 'completionsTotal',
            'completionsDay', 'lastseen'
            ]);
        return $this->response->setJSON($user);
    }

    public function getMyBalance()
    {
        return $this->response->setJSON($this->user->balance);
    }

    public function getMyDoneDay()
    {
        return $this->response->setJSON($this->user->done_day);
    }

    public function getStat()
    {
        // Онлайн
        if( ! $client_online = cache('clients_online')) {

            $db = Database::connect();
            $offsetTime = 60*60;
            $queryDate = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:00')) - $offsetTime);
            $query = $db->query("SELECT COUNT(id) as total FROM users WHERE lastseen > ?", $queryDate)->getRow();

            if($query) {
                $client_online = $query->total + 237;
            }

            cache()->save('clients_online', $client_online, 60);
        }

        $data = array(
            'online'	=> $client_online,
            'credits'	=> $this->user->balance,
            'watched'	=> $this->user->done,
            'id'		=> $this->user->id,
            'time'		=> time()
        );

        return $this->response->setJSON($data);
    }


    /* REFERRALS */

    public function getReferralList(int $page = 1)
    {
        $referrerId = 0;//$this->user-> id;

        $this->model
            ->select('id, avatar, username, earned, created_at, lastseen')
            ->where('referrer_id', $referrerId)
            ->orderBy('created_at DESC');

        // номер страницы
        $page = $page <= 0 ? 1 : (int) $page;

        $data = [
            'referrals' => $this->model->paginate($this->perPage, 'default', $page, $this->pageSegment),
            'pager'     => $this->model->pager->getDetails()
        ];

        return ! $data['referrals'] ? $this->failNotFound() : $this->respond($data);
    }

    public function getLatestReferralList()
    {
        $referrerId = 0; //$this->user->id;

        $referralList = $this->model
            ->select('id, avatar, username, earned, created_at, lastseen')
            ->where('referrer_id', $referrerId)
            ->orderBy('id DESC')
            ->limit($this->latestReferralListLimit)
            ->find();

        return $this->respond($referralList);
    }

    public function getTopReferralList()
    {
        $referrerId = 0;

        $referralList = $this->model
            ->select('id, avatar, username, earned, created_at, lastseen')
            ->where('referrer_id', $referrerId)
            ->orderBy('earned DESC')
            ->limit($this->latestReferralListLimit)
            ->find();

        return $this->respond($referralList);
    }

    public function getReferralStats()
    {
        $referrerId = 0;

        $data = [
            'link'          => site_url('/' . $referrerId),
            'total'         => $this->model->where('referrer_id', $referrerId)->countAll(),
            'activeTotal'   => $this->model->getActiveReferralsTotal($referrerId),
            'earnedTotal'   => number_format(round($this->model->getReferralsTotalEarned($referrerId)), 0, '.', ' ')
        ];

        return $this->respond($data);
    }
}
