<?php
namespace App\Controllers;

use  App\Models\AccountGoogleYoutubeModel;
use  App\Models\AccountVkModel;
use App\Entities\User;
use  CodeIgniter\API\ResponseTrait;
use Config\Services as Service;

class AuthController extends \Myth\Auth\Controllers\AuthController
{
    use ResponseTrait;

    /**
     * Logs in for Google authorization
     *
     *Redirect for Google
     *
     */
    public function googleLogin()
    {
        $client = Service::getGoogleClient();

        if (!isset($_GET['code']))
            return $this->failNotFound();

        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

        if (!isset($token) || isset($token["error"]))
        {
            return $this->failNotFound('Token error: '. $token['error']);
        }

        $_SESSION['google_oauth_token'] = $token;

        $googleOAuth = new \Google_Service_Oauth2($client);

        $googleId = $googleOAuth->userinfo->get()->id;

        // Search Google Youtube Account
        $accountGoogles = new AccountGoogleYoutubeModel();

        $accountGoogle = $accountGoogles->where('gid', $googleId)
            ->first();

        // Transparent registration
        if (!isset($accountGoogle)) {
            // TODO: register
            return $this->failNotFound('Google account not found');
        }

        $user = $accountGoogle->getBaseAccount()->getUser();

        $this->auth->login($user, true);

        $this->login();
    }

    public function login()
    {
        return parent::login();
    }

    public function logout()
    {
        if (isset($_SESSION['google_oauth_token']))
        {
            unset($_SESSION['google_oauth_token']);

            $client = Service::getGoogleClient();
            $client->revokeToken();
        }

        return parent::logout();
    }

    /**
     * Redirects to url of Google authorization
     *
     * @return void
     */
    public function redirectGoogleAuthUrl()
    {
        $client = Service::getGoogleClient();

        $authUrl = $client->createAuthUrl();

        return redirect()->to($authUrl);
    }

    /**
     * Attempt to register a new user.
     */
    public function attemptRegister()
    {
        // Check if registration is allowed
        if (! $this->config->allowRegistration)
        {
            return redirect()->back()->withInput()->with('error', lang('Auth.registerDisabled'));
        }

        $users = model('UserModel');

        // Validate here first, since some things,
        // like the password, can only be validated properly here.
        $rules = [
            'username'  	=> 'required|alpha_numeric_space|min_length[3]|is_unique[users.username]',
            'email'			=> 'required|valid_email|is_unique[users.email]',
            'password'	 	=> 'required|strong_password',
            'pass_confirm' 	=> 'required|matches[password]',
        ];

        if (! $this->validate($rules))
        {
            return redirect()->back()->withInput()->with('errors', service('validation')->getErrors());
        }

        // Save the user
        $allowedPostFields = array_merge(['password'], $this->config->validFields, $this->config->personalFields);
        $user = new User($this->request->getPost($allowedPostFields));

        $this->config->requireActivation !== false ? $user->generateActivateHash() : $user->activate();

        // Set referrer_id from session
        helper('session');
        if($referrer_id = session()->get('referrer_id')) {
            $user->setReferrerId((int) $referrer_id);
        }

        // Ensure default group gets assigned if set
        if (! empty($this->config->defaultUserGroup)) {
            $users = $users->withGroup($this->config->defaultUserGroup);
        }

        if (! $users->save($user))
        {
            return redirect()->back()->withInput()->with('errors', $users->errors());
        }

        if ($this->config->requireActivation !== false)
        {
            $activator = service('activator');
            $sent = $activator->send($user);

            if (! $sent)
            {
                return redirect()->back()->withInput()->with('error', $activator->error() ?? lang('Auth.unknownError'));
            }

            // Success!
            return redirect()->route('login')->with('message', lang('Auth.activationSuccess'));
        }

        // Success!
        return redirect()->route('login')->with('message', lang('Auth.registerSuccess'));
    }

    public function vkLogin()
    {
        $userId = $_GET['uid'];
        $hash =  $_GET['hash'];

        $appId = $this->config->vkClientId;
        $secretKey = $this->config->vkClientSecret;

        if ($hash !== md5($appId.$userId.$secretKey))
            return $this->failValidationError("Hash is invalid");

        $vkAccounts = new AccountVkModel();
        $accountVk = $vkAccounts->where('uid', $userId)
            ->first();

        if (!isset($accountVk)) {
            return $this->failNotFound('Google account not found');
        }

        $user = $accountVk->getBaseAccount()->getUser();

        $this->auth->login($user, true);

        $_SESSION['redirect_url'] = session('redirect_url') ?? base_url();

        return $this->login();
    }
}
