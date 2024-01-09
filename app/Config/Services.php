<?php namespace Config;

use CodeIgniter\Config\Services as CoreServices;


use CodeIgniter\Model;

use App\Models\UserModel;


require_once SYSTEMPATH . 'Config/Services.php';

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends CoreServices
{
    public static function getGoogleClient($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('getGoogleClient');
        }
        $config = config('Auth');

        $redirectUrl = $config->googleRedirectURL;

        $client = new \Google_Client();

        $client->setAuthConfig($config->googleConfigPath);

        $scopes = $config->googleScopes;

        foreach ($scopes as $scope)
            $client->addScope($scope);

        $client->setRedirectUri($redirectUrl);
        $client->setAccessType($config->googleAccessType);
        $client->setState($config->googleState);// offline access
        $client->setIncludeGrantedScopes(true);   // incremental auth

        return $client;
    }

    /**
     *
     * This wrapper needs for forced use App\Models\UserModel in MythAuth Classes
     *
     * @param string $lib
     * @param Model|null $userModel
     * @param Model|null $loginModel
     * @param bool $getShared
     * @return mixed
     */
    public static function authentication(string $lib = 'local', Model $userModel=null, Model $loginModel=null, bool $getShared = true)
    {
        if(empty($userModel))
        {
            $userModel = new UserModel();
        }

        return \Myth\Auth\Config\Services::authentication($lib, $userModel);
    }
}
