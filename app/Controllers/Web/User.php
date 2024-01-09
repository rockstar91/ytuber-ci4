<?php
namespace App\Controllers\Web;

use App\Controllers\BaseController;
use \App\Models\UserModel;

class User extends BaseController
{
    protected $helpers = ['Auth', 'form', 'url'];

    public function setting()
    {
        $user = user();

        $viewData = [
            'pageTitle' => lang('User.setting_title'),
            'user' => $user,
        ];


        $settingValidationRules = [
            'name' => ['label' => lang('User.name'), 'rules' => 'trim|required'],
            'password' => ['label' => lang('User.password'), 'rules' => 'trim|password[8,16]'],
            'password_confirm' => ['label' => lang('User.password_confirm'), 'rules' => 'trim|password_confirm[password]'],
        ];

        if ( $this->request->getPost() && $this->validate($settingValidationRules) )
        {
            $updateData = [
                'username'			=> $this->request->getPost('name'),
                'sub_news'			=> (booL)$this->request->getPost('sub_news'),
                'sub_transaction'	=> (bool)$this->request->getPost('sub_transaction'),
                'sub_statistic'		=> (bool)$this->request->getPost('sub_statistic'),
                'sub_notification'	=> (bool)$this->request->getPost('sub_notification'),
            ];

            // Генерируем новый API-key
            if($this->request->getPost('api_key_generate'))
            {
                $user->generateApiKey();
                $viewData['success'][] = lang('User.success_api');
            }

            // Изменение пароля, если указан
            $password = $this->request->getPost('password');

            if( ! empty($password) )
            {
                $user->setPassword($password);
            }

            // Заполнение данных пользователя
            $user->fill($updateData);

            // Сохранение данных
            $userModel = new \App\Models\UserModel();

            $updateResult = $userModel->update($user->id, $user);

            if( $updateResult )
            {
                $viewData['success'][] = lang('User.success_update');
            }
            else
            {
                // Тут могут быть ошибки валидации в модели
                $errors = $userModel->errors();
            }


        }
        else if( $this->request->getPost() )
        {
            $viewData['validator'] = $this->validator;
        }

        return view('Shitcode/user/setting', $viewData);
    }
}