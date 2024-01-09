<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 12.05.2020
 * Time: 18:27
 */

namespace App\Entities;
use App\Traits\Entities\ComputedAttributes;
use Myth\Auth\Entities\User as MythAuth_UserEntity;

use App\Entities\AccountGoogleYoutube;

class User extends MythAuth_UserEntity
{
    use ComputedAttributes;

    protected $fillComputedAttributes = ['isOnline'];

    protected $datamap = [
        'completionsTotal'  => 'done',
        'completionsDay'    => 'done_day',
        'credits'           => 'balance',
        'shortname'         => 'shortname'
    ];

    public function __construct(array $data = null)
    {
        $this->computedAttributes = $this->fillComputedAttributes;

        parent::__construct($data);

        // TODO: добавить необходимые поля
        $this->casts = array_merge($this->casts, [
            'admin'     => 'boolean',
            'disabled'  => 'boolean',
            'sub_news'  => 'boolean'
        ]);

        $this->dates = array_merge($this->dates, [
            'lastseen', 'channel_published'
        ]);
    }

    public function calculateIsOnline(array $data = null)
    {
        $period = 5 * 60;

        $result = false;

        if(
            isset($data['lastseen']) AND
            strtotime($data['lastseen']) > (time() - $period)
        ) {
           $result = true;
        }

        return $result;
    }

    public function isAdmin() : bool
    {
        return (bool) $this->attributes['admin'];
    }

    public function isBanned() : bool
    {
        return ($this->attributes['banned'] > time()) || parent::isBanned();
    }

    public function generateApiKey() : self
    {
        helper('strgen');

        $this->attributes['api_key'] = strgen(40);

        return $this;
    }

    public function getUsername($len=null) : string
    {
        $username = $this->attributes['username'];

        if( ! is_int($len) )
        {
            return $username;
        }

        $shortname = mb_substr($username, 0, $len);

        if($shortname != $username)
        {
            return $shortname . '...';
        }

        return $username;
    }

    public function setReferrerId(int $referrer_id) : self
    {
        $this->attributes['referrer_id'] = $referrer_id;

        return $this;
    }

    public function getGoogleYoutubeAccount() : ?AccountGoogleYoutube
    {
        $accountGoogleYoutubeModel = new \App\Models\AccountGoogleYoutubeModel();
        return $accountGoogleYoutubeModel->where('user_id', $this->attributes['id'])->first();
    }

    public function getAttributes($attributeKeys = [])
    {
        if(count($attributeKeys) <= 0)
        {
            return $this->attributes;
        }

        $user = $this->toArray();

        $result = [];

        foreach ($attributeKeys as $key)
        {
            if(isset($user[$key]))
            {
                $result[$key] = $user[$key];
            }
        }

        return $result;
    }
}