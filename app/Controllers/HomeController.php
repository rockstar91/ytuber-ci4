<?php


namespace App\Controllers;

class HomeController extends BaseController
{

    public function __construct()
    {
        helper('Auth');
    }

    public function index()
    {
        helper('Form');

        return view("Shitcode/index", [
            'config' => config('Auth'),
            'user'   => user()
        ]);
    }

    public function rememberReferrerId()
    {
        helper('session');

        $referrer_id = (int) $this->request->uri->getSegment(1) ?? (int) $this->request->getGet('r');

        if($referrer_id > 0)
        {
            $userModel = new \App\Models\UserModel();

            if($user = $userModel->find($referrer_id))
            {
                session()->set('referrer_id', $referrer_id);
            }

            return redirect()->to('/');
        }
    }
}
