<?php
/**
 * Created by PhpStorm.
 * User: me
 * Date: 12.05.2020
 * Time: 14:23
 */

namespace App\Controllers\Api;
use CodeIgniter\RESTful\ResourceController;

use App\Models\UserModel;

class BaseApiController extends ResourceController
{
    use \Myth\Auth\AuthTrait;

    protected $helpers = ['Auth'];

    public $errors = [
        'user_not_found' => 'User not found (wrong API-key)',
    ];

    protected $methodsMapping = [];

    protected $user = null;

    protected function authByApiKey()
    {
        $userModel = new UserModel;

        $apiKey = $this->request->getVar('api_key');
        $this->user = $userModel->getUserByApiKey($apiKey);

        return $this->isUserFound();
    }

    protected function authBySession()
    {
        helper('Auth');

        if(logged_in())
        {
            $this->user = user();
            return true;
        }

        return false;
    }

    protected function isUserFound()
    {
        if($this->user) {
            return true;
        }

        return false;
    }

    public function _remap($name, ...$arguments)
    {
        // Проверка авторизации по API-ключу
        if(!$this->authByApiKey() && !$this->authBySession())
        {
            return $this->fail($this->errors['user_not_found'], 401);
        }

        // Переадресация метода, если есть ссылка в $this->methodsMapping
        if(isset($this->methodsMapping[$name]) && method_exists($this, $this->methodsMapping[$name]))
        {
            return $this->{$this->methodsMapping[$name]}(...$arguments);
        }

        // Вызов исходного метода
        else if (method_exists($this, $name))
        {
            return $this->{$name}(...$arguments);
        }

        return false;
    }
}
